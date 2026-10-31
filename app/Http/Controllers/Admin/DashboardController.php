<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Konsultasi;
use App\Models\ManajemenMasterJasa;
use App\Models\ManajemenProfil;
use App\Models\Portofolio;
use App\Models\Qa;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'portofolio' => Portofolio::count(),
            'qa' => Qa::count(),
            'berita' => Berita::count(),
            'user' => User::count(),
            'jasa' => ManajemenMasterJasa::count(),
            'konsultasi' => Konsultasi::count(),
            'konsultasi_baru' => Konsultasi::where('status', 'baru')->count(),
        ];

        $latestPortofolio = Portofolio::latest()->take(5)->get();
        $latestBerita = Berita::latest()->take(5)->get();
        $latestKonsultasi = Konsultasi::latest()->take(5)->get();
        $profil = ManajemenProfil::first();

        return view('admin.dashboard', compact('stats', 'latestPortofolio', 'latestBerita', 'latestKonsultasi', 'profil'));
    }
}
