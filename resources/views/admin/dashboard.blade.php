@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Selamat datang di panel kontrol manajemen Coretech Studio')

@section('content')
<!-- STATS ROW -->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <!-- Pesan Konsultasi Masuk -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <i class="ki-duotone ki-messages text-danger fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    @if($stats['konsultasi_baru'] > 0)
                        <span class="badge badge-danger fw-bold fs-8">{{ $stats['konsultasi_baru'] }} Baru</span>
                    @endif
                </div>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['konsultasi'] }}</div>
                <div class="fw-semibold text-gray-500">Permintaan Konsultasi Masuk</div>
                <div class="mt-4">
                    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-sm btn-light-danger">Lihat Pesan Konsultasi &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Portofolio -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <i class="ki-duotone ki-briefcase text-primary fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['portofolio'] }}</div>
                <div class="fw-semibold text-gray-500">Total Portofolio Proyek</div>
                <div class="mt-4">
                    <a href="{{ route('admin.portofolio.index') }}" class="btn btn-sm btn-light-primary">Kelola Portofolio &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <i class="ki-duotone ki-newspaper text-info fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['berita'] }}</div>
                <div class="fw-semibold text-gray-500">Artikel & Berita Terbit</div>
                <div class="mt-4">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-light-info">Kelola Berita &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Master Jasa -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <i class="ki-duotone ki-price-tag text-warning fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['jasa'] }}</div>
                <div class="fw-semibold text-gray-500">Paket & Master Jasa Tersedia</div>
                <div class="mt-4">
                    <a href="{{ route('admin.master-jasa.index') }}" class="btn btn-sm btn-light-warning">Kelola Master Jasa &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- QA -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <i class="ki-duotone ki-message-question text-success fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['qa'] }}</div>
                <div class="fw-semibold text-gray-500">Testimoni & Tanya Jawab (QA)</div>
                <div class="mt-4">
                    <a href="{{ route('admin.qa.index') }}" class="btn btn-sm btn-light-success">Kelola QA &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- User -->
    <div class="col-xl-4 col-md-6">
        <div class="card bg-body-white hoverable card-xl-stretch mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-body">
                <i class="ki-duotone ki-profile-user text-dark fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ $stats['user'] }}</div>
                <div class="fw-semibold text-gray-500">Administrator Terdaftar</div>
                <div class="mt-4">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-light-dark">Kelola Pengguna &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LATEST KONSULTASI INQUIRIES -->
<div class="card card-xl-stretch mb-5 mb-xl-8 border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-4 text-gray-900">Permintaan Konsultasi Masuk Terbaru</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Prospek klien yang mengisi formulir konsultasi landing page</span>
        </h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-sm btn-primary">Buka Semua Pesan</a>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 min-w-180px rounded-start">Nama & Perusahaan</th>
                        <th class="min-w-150px">Kontak</th>
                        <th class="min-w-150px">Layanan Minat</th>
                        <th class="min-w-200px">Pesan</th>
                        <th class="min-w-100px">Status</th>
                        <th class="min-w-80px text-end pe-4 rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestKonsultasi as $k)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px symbol-circle me-3">
                                        <div class="symbol-label fs-6 fw-bold bg-light-danger text-danger">
                                            {{ strtoupper(substr($k->nama, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-900 fw-bold fs-6">{{ $k->nama }}</span>
                                        <span class="text-muted fs-8">{{ $k->perusahaan ?: 'Perorangan' }} &bull; {{ $k->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fs-7">{{ $k->email }}</span>
                                    <span class="text-muted fs-8">{{ $k->nomor_telepon }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-primary fs-8 fw-semibold text-wrap">{{ $k->layanan ?: 'Konsultasi Umum' }}</span>
                            </td>
                            <td>
                                <span class="text-gray-700 fs-7 text-truncate d-inline-block" style="max-width: 250px;">{{ Str::limit($k->pesan, 70) }}</span>
                            </td>
                            <td>
                                @if($k->status === 'baru')
                                    <span class="badge badge-light-danger fw-bold fs-8">Baru</span>
                                @elseif($k->status === 'dihubungi')
                                    <span class="badge badge-light-warning fw-bold fs-8">Dihubungi</span>
                                @else
                                    <span class="badge badge-light-success fw-bold fs-8">Selesai</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-muted">Belum ada pesan konsultasi yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- LATEST PORTOFOLIO & BERITA PREVIEWS -->
<div class="row g-5 g-xl-8">
    <!-- Portofolio Preview -->
    <div class="col-xl-6">
        <div class="card card-xl-stretch mb-5 mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-4 text-gray-900">Portofolio Terbaru</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Karya dan proyek digital terkini</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.portofolio.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="ps-4 min-w-150px rounded-start">Nama Proyek</th>
                                <th class="min-w-80px">Foto</th>
                                <th class="min-w-100px text-end pe-4 rounded-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPortofolio as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $item->nama }}</span>
                                                <span class="text-muted fw-semibold text-muted d-block fs-7 text-truncate" style="max-width: 250px;">
                                                    {{ Str::limit($item->keterangan, 50) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if(is_array($item->foto) && count($item->foto) > 0)
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img src="{{ $item->foto[0] }}" alt="Foto" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=100&q=80'" />
                                            </div>
                                            <span class="badge badge-light-primary ms-1 fs-8">{{ count($item->foto) }}</span>
                                        @else
                                            <span class="text-muted fs-8">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.portofolio.index') }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada portofolio.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita Preview -->
    <div class="col-xl-6">
        <div class="card card-xl-stretch mb-5 mb-xl-8 border border-gray-200 shadow-sm">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-4 text-gray-900">Berita & Artikel Terbaru</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Update publikasi konten</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="ps-4 min-w-150px rounded-start">Judul</th>
                                <th class="min-w-80px">Status</th>
                                <th class="min-w-100px text-end pe-4 rounded-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBerita as $berita)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-gray-900 fw-bold fs-6">{{ $berita->judul }}</span>
                                                <span class="text-muted fw-semibold d-block fs-7">{{ $berita->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $berita->status === 'published' ? 'badge-light-success' : 'badge-light-warning' }} fs-8 fw-bold">
                                            {{ ucfirst($berita->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.berita.index') }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada berita.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
