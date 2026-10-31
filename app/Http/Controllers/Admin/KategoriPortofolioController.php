<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPortofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KategoriPortofolioController extends Controller
{
    public function index(Request $request): View
    {
        $query = KategoriPortofolio::withCount('portofolios');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kategori-portofolio.index', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_portofolios,nama'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'warna' => ['nullable', 'string', 'max:20'],
        ]);

        KategoriPortofolio::create([
            'nama' => $validated['nama'],
            'slug' => Str::slug($validated['nama']),
            'keterangan' => $validated['keterangan'] ?? null,
            'warna' => $validated['warna'] ?: '#a78bfa',
        ]);

        return redirect()->route('admin.kategori-portofolio.index')
            ->with('success', 'Master kategori portofolio berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriPortofolio $kategoriPortofolio): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_portofolios,nama,'.$kategoriPortofolio->id],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'warna' => ['nullable', 'string', 'max:20'],
        ]);

        $kategoriPortofolio->update([
            'nama' => $validated['nama'],
            'slug' => Str::slug($validated['nama']),
            'keterangan' => $validated['keterangan'] ?? null,
            'warna' => $validated['warna'] ?: '#a78bfa',
        ]);

        return redirect()->route('admin.kategori-portofolio.index')
            ->with('success', 'Master kategori portofolio berhasil diperbarui.');
    }

    public function destroy(KategoriPortofolio $kategoriPortofolio): RedirectResponse
    {
        $kategoriPortofolio->delete();

        return redirect()->route('admin.kategori-portofolio.index')
            ->with('success', 'Master kategori portofolio berhasil dihapus.');
    }
}
