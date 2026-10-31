<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManajemenMasterJasa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MasterJasaController extends Controller
{
    public function index(): View
    {
        $jasas = ManajemenMasterJasa::latest()->paginate(10);

        return view('admin.master-jasa.index', compact('jasas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'jasa' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        ManajemenMasterJasa::create([
            'jasa' => $request->input('jasa'),
            'harga' => (int) $request->input('harga'),
        ]);

        return redirect()->route('admin.master-jasa.index')->with('success', 'Master Jasa berhasil ditambahkan.');
    }

    public function update(Request $request, ManajemenMasterJasa $masterJasa): RedirectResponse
    {
        $request->validate([
            'jasa' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        $masterJasa->update([
            'jasa' => $request->input('jasa'),
            'harga' => (int) $request->input('harga'),
        ]);

        return redirect()->route('admin.master-jasa.index')->with('success', 'Master Jasa berhasil diperbarui.');
    }

    public function destroy(ManajemenMasterJasa $masterJasa): RedirectResponse
    {
        $masterJasa->delete();

        return redirect()->route('admin.master-jasa.index')->with('success', 'Master Jasa berhasil dihapus.');
    }
}
