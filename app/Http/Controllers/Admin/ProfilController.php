<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManajemenProfil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function index(): View
    {
        $profil = ManajemenProfil::first();

        return view('admin.profil.index', compact('profil'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'namaPerusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'nomorTelepon' => ['required', 'string', 'max:50'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'treads' => ['nullable', 'string', 'max:255'],
            'linkedIN' => ['nullable', 'string', 'max:255'],
        ]);

        $profil = ManajemenProfil::first();

        if ($profil) {
            $profil->update($request->only([
                'namaPerusahaan',
                'alamat',
                'email',
                'nomorTelepon',
                'instagram',
                'tiktok',
                'treads',
                'linkedIN',
            ]));
        } else {
            ManajemenProfil::create($request->only([
                'namaPerusahaan',
                'alamat',
                'email',
                'nomorTelepon',
                'instagram',
                'tiktok',
                'treads',
                'linkedIN',
            ]));
        }

        return redirect()->route('admin.profil.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
