<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriPortofolio;
use App\Models\Konsultasi;
use App\Models\ManajemenMasterJasa;
use App\Models\ManajemenProfil;
use App\Models\Portofolio;
use App\Models\Qa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $portofolios = Portofolio::with('kategori')->latest()->take(3)->get();
        $beritas = Berita::where('status', 'published')->latest()->take(3)->get();
        $qas = Qa::latest()->get();
        $profil = ManajemenProfil::first();
        $masterJasas = ManajemenMasterJasa::latest()->get();

        return view('welcome', compact('portofolios', 'beritas', 'qas', 'profil', 'masterJasas'));
    }

    public function portofolio(Request $request): View
    {
        $query = Portofolio::with('kategori');
        $selectedKategori = null;

        if ($request->filled('kategori')) {
            $slug = trim((string) $request->input('kategori'));
            $selectedKategori = KategoriPortofolio::where('slug', $slug)->first();
            if ($selectedKategori) {
                $query->where('kategori_id', $selectedKategori->id);
            }
        }

        $portofolios = $query->latest()->paginate(9)->withQueryString();
        $kategoris = KategoriPortofolio::withCount('portofolios')->orderBy('nama')->get();
        $profil = ManajemenProfil::first();
        $masterJasas = ManajemenMasterJasa::latest()->get();

        return view('portofolio.index', compact('portofolios', 'kategoris', 'selectedKategori', 'profil', 'masterJasas'));
    }

    public function berita(Request $request): View
    {
        $query = Berita::where('status', 'published');

        if ($request->filled('q')) {
            $search = trim((string) $request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $beritas = $query->latest()->paginate(9)->withQueryString();
        $featuredBerita = Berita::where('status', 'published')->latest()->first();
        $profil = ManajemenProfil::first();
        $masterJasas = ManajemenMasterJasa::latest()->get();

        return view('berita.index', compact('beritas', 'featuredBerita', 'profil', 'masterJasas'));
    }

    public function beritaDetail(string $uuid): View
    {
        $berita = Berita::where('uuid', $uuid)->where('status', 'published')->first();

        if (! $berita && is_numeric($uuid)) {
            $berita = Berita::where('id', $uuid)->where('status', 'published')->first();
        }

        abort_if(! $berita, 404, 'Artikel berita tidak ditemukan atau telah diarsipkan.');

        $recentBeritas = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(5)
            ->get();

        $profil = ManajemenProfil::first();
        $masterJasas = ManajemenMasterJasa::latest()->get();

        return view('berita.show', compact('berita', 'recentBeritas', 'profil', 'masterJasas'));
    }

    public function submitKonsultasi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:50'],
            'perusahaan' => ['nullable', 'string', 'max:255'],
            'layanan' => ['nullable', 'string', 'max:255'],
            'pesan' => ['required', 'string', 'max:5000'],
        ]);

        Konsultasi::create(array_merge($validated, [
            'status' => 'baru',
        ]));

        return redirect()->to(url('/#consultation'))
            ->with('consultation_success', 'Terima kasih atas kepercayaan Anda! Permintaan konsultasi berhasil dikirim. Konsultan teknologi kami akan menghubungi Anda dalam waktu 1x24 jam kerja.');
    }
}
