@extends('admin.layout')

@section('title', 'Manajemen Pesan Konsultasi')
@section('page_title', 'Pesan Konsultasi & Prospek Klien')
@section('page_subtitle', 'Daftar pesan masuk dan permintaan konsultasi proyek dari calon klien')

@section('content')
<!-- STATUS FILTER CARDS -->
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.konsultasi.index') }}" class="card border {{ empty($status) ? 'border-primary bg-light-primary' : 'border-gray-200 bg-body-white' }} shadow-sm text-decoration-none">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="fs-7 fw-semibold text-gray-600 d-block">Semua Pesan</span>
                    <span class="fs-2 fw-bold text-gray-900">{{ $counts['total'] }}</span>
                </div>
                <i class="ki-duotone ki-messages fs-2x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.konsultasi.index', ['status' => 'baru']) }}" class="card border {{ $status === 'baru' ? 'border-danger bg-light-danger' : 'border-gray-200 bg-body-white' }} shadow-sm text-decoration-none">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="fs-7 fw-semibold text-gray-600 d-block">Baru (Belum Dihubungi)</span>
                    <span class="fs-2 fw-bold text-danger">{{ $counts['baru'] }}</span>
                </div>
                <i class="ki-duotone ki-notification-on fs-2x text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.konsultasi.index', ['status' => 'dihubungi']) }}" class="card border {{ $status === 'dihubungi' ? 'border-warning bg-light-warning' : 'border-gray-200 bg-body-white' }} shadow-sm text-decoration-none">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="fs-7 fw-semibold text-gray-600 d-block">Sedang Dihubungi</span>
                    <span class="fs-2 fw-bold text-warning">{{ $counts['dihubungi'] }}</span>
                </div>
                <i class="ki-duotone ki-phone fs-2x text-warning"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.konsultasi.index', ['status' => 'selesai']) }}" class="card border {{ $status === 'selesai' ? 'border-success bg-light-success' : 'border-gray-200 bg-body-white' }} shadow-sm text-decoration-none">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="fs-7 fw-semibold text-gray-600 d-block">Selesai / Deal</span>
                    <span class="fs-2 fw-bold text-success">{{ $counts['selesai'] }}</span>
                </div>
                <i class="ki-duotone ki-check-circle fs-2x text-success"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </a>
    </div>
</div>

<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">
                Data Konsultasi Masuk
                @if($status)
                    <span class="badge badge-light-primary ms-2 fs-8">Filter: {{ ucfirst($status) }}</span>
                @endif
            </h3>
        </div>
        @if($status)
            <div class="card-toolbar">
                <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-sm btn-light">Reset Filter</a>
            </div>
        @endif
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-180px">Calon Klien</th>
                        <th class="min-w-180px">Kontak</th>
                        <th class="min-w-160px">Layanan Minat</th>
                        <th class="min-w-220px">Isi Pesan</th>
                        <th class="min-w-100px">Status</th>
                        <th class="text-end min-w-120px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($konsultasis as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px symbol-circle me-3">
                                        <div class="symbol-label fs-5 fw-bold {{ $item->status === 'baru' ? 'bg-light-danger text-danger' : 'bg-light-primary text-primary' }}">
                                            {{ strtoupper(substr($item->nama, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-900 fw-bold fs-6">{{ $item->nama }}</span>
                                        @if($item->perusahaan)
                                            <span class="text-muted fs-8 fw-semibold">{{ $item->perusahaan }}</span>
                                        @endif
                                        <span class="text-muted fs-8 mt-1 font-monospace">{{ $item->created_at->format('d M Y, H:i') }} ({{ $item->created_at->diffForHumans() }})</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="mailto:{{ $item->email }}" class="text-gray-800 text-hover-primary fs-7 d-flex align-items-center gap-1">
                                        <i class="ki-duotone ki-sms fs-7 text-muted"><span class="path1"></span><span class="path2"></span></i>
                                        {{ $item->email }}
                                    </a>
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $item->nomor_telepon);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($item->nama) }},%20terima%20kasih%20telah%20menghubungi%20Coretech%20Studio." target="_blank" class="text-success text-hover-primary fs-7 d-flex align-items-center gap-1">
                                        <i class="ki-duotone ki-whatsapp fs-7 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        {{ $item->nomor_telepon }}
                                    </a>
                                </div>
                            </td>
                            <td>
                                @if($item->layanan)
                                    <span class="badge badge-light-primary fs-8 fw-semibold text-wrap" style="max-width: 170px;">
                                        {{ $item->layanan }}
                                    </span>
                                @else
                                    <span class="text-muted fs-8">-</span>
                                @endif
                            </td>
                            <td>
                                <p class="text-gray-700 fs-7 mb-0 text-truncate" style="max-width: 250px;" title="{{ $item->pesan }}">
                                    {{ Str::limit($item->pesan, 90) }}
                                </p>
                                @if($item->catatan_admin)
                                    <span class="badge badge-light-info fs-8 mt-1 d-inline-block text-truncate" style="max-width: 250px;" title="Catatan Admin: {{ $item->catatan_admin }}">
                                        Catatan: {{ Str::limit($item->catatan_admin, 40) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'baru')
                                    <span class="badge badge-light-danger fw-bold fs-8">Baru</span>
                                @elseif($item->status === 'dihubungi')
                                    <span class="badge badge-light-warning fw-bold fs-8">Dihubungi</span>
                                @else
                                    <span class="badge badge-light-success fw-bold fs-8">Selesai</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalDetailKonsultasi{{ $item->id }}" title="Lihat & Proses">
                                    <i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.konsultasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan konsultasi dari {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Detail & Update Status Konsultasi -->
                        <div class="modal fade" id="modalDetailKonsultasi{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.konsultasi.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Detail Pesan Konsultasi</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-8 px-lg-12">
                                            <div class="d-flex align-items-center mb-6">
                                                <div class="symbol symbol-50px symbol-circle me-3">
                                                    <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-gray-900 fw-bold mb-0">{{ $item->nama }}</h3>
                                                    <span class="text-muted fs-7">{{ $item->perusahaan ?: 'Perorangan' }}</span>
                                                    <div class="text-muted fs-8 font-monospace mt-1">{{ $item->created_at->format('d M Y, H:i') }} (WIB)</div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-6 p-4 rounded bg-light">
                                                <div class="col-6">
                                                    <span class="text-muted fs-8 fw-bold text-uppercase d-block">Email</span>
                                                    <a href="mailto:{{ $item->email }}" class="text-gray-900 fw-semibold fs-7">{{ $item->email }}</a>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted fs-8 fw-bold text-uppercase d-block">Nomor Telepon / WA</span>
                                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="text-success fw-bold fs-7">
                                                        <i class="ki-duotone ki-whatsapp fs-7 me-1"></i> {{ $item->nomor_telepon }}
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <span class="text-muted fs-8 fw-bold text-uppercase d-block">Minat Layanan</span>
                                                    <span class="text-gray-900 fw-semibold fs-7">{{ $item->layanan ?: 'Konsultasi Umum' }}</span>
                                                </div>
                                            </div>

                                            <div class="mb-6">
                                                <label class="fs-7 fw-bold text-gray-700 text-uppercase mb-2 d-block">Isi Permintaan & Kebutuhan Proyek:</label>
                                                <div class="p-4 rounded bg-body-tertiary border text-gray-800 fs-7" style="white-space: pre-line; line-height: 1.6;">
                                                    {{ $item->pesan }}
                                                </div>
                                            </div>

                                            <div class="separator separator-dashed my-6"></div>

                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Update Status Prospek</label>
                                                <select class="form-select form-select-solid" name="status" required>
                                                    <option value="baru" {{ $item->status === 'baru' ? 'selected' : '' }}>Baru (Belum Ditindaklanjuti)</option>
                                                    <option value="dihubungi" {{ $item->status === 'dihubungi' ? 'selected' : '' }}>Dihubungi (Sedang Komunikasi / Penawaran)</option>
                                                    <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai (Deal / Proyek Diterima)</option>
                                                </select>
                                            </div>

                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Catatan Internal Administrator</label>
                                                <textarea class="form-control form-control-solid" rows="3" name="catatan_admin" placeholder="Contoh: Sudah dikontak via WA, klien minta proposal penawaran harga...">{{ old('catatan_admin', $item->catatan_admin) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer flex-center">
                                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($item->nama) }},%20kami%20dari%20tim%20Coretech%20Studio%20ingin%20menindaklanjuti%20permintaan%20konsultasi%20Anda." target="_blank" class="btn btn-light-success me-auto">
                                                <i class="ki-duotone ki-whatsapp fs-3 me-1"></i> Hubungi WhatsApp
                                            </a>
                                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan Status & Catatan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-muted">Belum ada pesan konsultasi yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $konsultasis->links() }}
        </div>
    </div>
</div>
@endsection
