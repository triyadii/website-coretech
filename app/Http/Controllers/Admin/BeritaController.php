<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(): View
    {
        $beritas = Berita::latest()->paginate(10);

        return view('admin.berita.index', compact('beritas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'gambar_url' => ['nullable', 'url', 'max:500'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        $gambar = $request->input('gambar_url');

        if ($request->hasFile('gambar_file')) {
            $file = $request->file('gambar_file');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/berita'), $filename);
            $gambar = asset('uploads/berita/'.$filename);
        }

        Berita::create([
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $gambar,
            'status' => $request->input('status', 'published'),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'gambar_url' => ['nullable', 'url', 'max:500'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        $gambar = $berita->gambar;

        if ($request->filled('gambar_url')) {
            $gambar = $request->input('gambar_url');
        }

        if ($request->hasFile('gambar_file')) {
            $file = $request->file('gambar_file');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/berita'), $filename);
            $gambar = asset('uploads/berita/'.$filename);
        }

        $berita->update([
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $gambar,
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
