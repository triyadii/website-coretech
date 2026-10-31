<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KonsultasiController;
use App\Http\Controllers\Admin\MasterJasaController;
use App\Http\Controllers\Admin\PortofolioController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\QaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Landing Page, News, Portfolio & Consultation Form
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portofolio', [HomeController::class, 'portofolio'])->name('portofolio.public');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita.public');
Route::get('/berita/{uuid}', [HomeController::class, 'beritaDetail'])->name('berita.show');
Route::post('/konsultasi', [HomeController::class, 'submitKonsultasi'])->name('konsultasi.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Backoffice Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Portofolio Management
    Route::resource('portofolio', PortofolioController::class)
        ->parameters(['portofolio' => 'portofolio'])
        ->except(['create', 'edit', 'show']);

    // 2. QA Management
    Route::resource('qa', QaController::class)
        ->parameters(['qa' => 'qa'])
        ->except(['create', 'edit', 'show']);

    // 3. Berita Management
    Route::resource('berita', BeritaController::class)
        ->parameters(['berita' => 'berita'])
        ->except(['create', 'edit', 'show']);

    // 4. Manajemen Profil
    Route::get('profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('profil', [ProfilController::class, 'update'])->name('profil.update');

    // 5. Manajemen User
    Route::resource('user', UserController::class)
        ->parameters(['user' => 'user'])
        ->except(['create', 'edit', 'show']);

    // 6. Manajemen Master Jasa
    Route::resource('master-jasa', MasterJasaController::class)
        ->parameters(['master-jasa' => 'masterJasa'])
        ->except(['create', 'edit', 'show']);

    // 7. Manajemen Pesan Konsultasi
    Route::resource('konsultasi', KonsultasiController::class)
        ->parameters(['konsultasi' => 'konsultasi'])
        ->only(['index', 'update', 'destroy']);
});
