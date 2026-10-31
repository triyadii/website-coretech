<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortofolioController extends Controller
{
    public function index(): View
    {
        $portofolios = Portofolio::latest()->paginate(10);

        return view('admin.portofolio.index', compact('portofolios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
            'link' => ['nullable', 'url', 'max:255'],
            'foto_urls' => ['nullable', 'string'],
            'foto_files.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        $photos = [];

        // Parse URLs if provided
        if ($request->filled('foto_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->input('foto_urls'))));
            foreach ($urls as $u) {
                if (count($photos) < 3 && filter_var($u, FILTER_VALIDATE_URL)) {
                    $photos[] = $u;
                }
            }
        }

        // Handle uploaded files
        if ($request->hasFile('foto_files')) {
            foreach ($request->file('foto_files') as $file) {
                if (count($photos) < 3) {
                    $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/portofolio'), $filename);
                    $photos[] = asset('uploads/portofolio/'.$filename);
                }
            }
        }

        Portofolio::create([
            'nama' => $request->input('nama'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'foto' => $photos,
        ]);

        return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function update(Request $request, Portofolio $portofolio): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
            'link' => ['nullable', 'url', 'max:255'],
            'foto_urls' => ['nullable', 'string'],
            'foto_files.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        $photos = is_array($portofolio->foto) ? $portofolio->foto : [];

        if ($request->filled('foto_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->input('foto_urls'))));
            $photos = [];
            foreach ($urls as $u) {
                if (count($photos) < 3 && filter_var($u, FILTER_VALIDATE_URL)) {
                    $photos[] = $u;
                }
            }
        }

        if ($request->hasFile('foto_files')) {
            foreach ($request->file('foto_files') as $file) {
                if (count($photos) < 3) {
                    $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/portofolio'), $filename);
                    $photos[] = asset('uploads/portofolio/'.$filename);
                }
            }
        }

        $portofolio->update([
            'nama' => $request->input('nama'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'foto' => $photos,
        ]);

        return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portofolio $portofolio): RedirectResponse
    {
        $portofolio->delete();

        return redirect()->route('admin.portofolio.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}
