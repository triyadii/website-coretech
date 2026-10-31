<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KonsultasiController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Konsultasi::latest();

        if ($status && in_array($status, ['baru', 'dihubungi', 'selesai'])) {
            $query->where('status', $status);
        }

        $konsultasis = $query->paginate(10)->withQueryString();

        $counts = [
            'total' => Konsultasi::count(),
            'baru' => Konsultasi::where('status', 'baru')->count(),
            'dihubungi' => Konsultasi::where('status', 'dihubungi')->count(),
            'selesai' => Konsultasi::where('status', 'selesai')->count(),
        ];

        return view('admin.konsultasi.index', compact('konsultasis', 'counts', 'status'));
    }

    public function update(Request $request, Konsultasi $konsultasi): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:baru,dihubungi,selesai'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $konsultasi->update([
            'status' => $request->input('status'),
            'catatan_admin' => $request->input('catatan_admin'),
        ]);

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Status konsultasi dari '.$konsultasi->nama.' berhasil diperbarui.');
    }

    public function destroy(Konsultasi $konsultasi): RedirectResponse
    {
        $nama = $konsultasi->nama;
        $konsultasi->delete();

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Data konsultasi dari '.$nama.' berhasil dihapus.');
    }
}
