<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QaController extends Controller
{
    public function index(): View
    {
        $qas = Qa::latest()->paginate(10);

        return view('admin.qa.index', compact('qas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'perusahaan' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
        ]);

        Qa::create([
            'nama' => $request->input('nama'),
            'perusahaan' => $request->input('perusahaan'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('admin.qa.index')->with('success', 'Data QA berhasil ditambahkan.');
    }

    public function update(Request $request, Qa $qa): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'perusahaan' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
        ]);

        $qa->update([
            'nama' => $request->input('nama'),
            'perusahaan' => $request->input('perusahaan'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('admin.qa.index')->with('success', 'Data QA berhasil diperbarui.');
    }

    public function destroy(Qa $qa): RedirectResponse
    {
        $qa->delete();

        return redirect()->route('admin.qa.index')->with('success', 'Data QA berhasil dihapus.');
    }
}
