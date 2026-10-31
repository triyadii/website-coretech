@extends('admin.layout')

@section('title', 'Manajemen Profil Perusahaan')
@section('page_title', 'Profil Perusahaan')
@section('page_subtitle', 'Informasi kontak dan identitas software house yang tampil di landing page & footer')

@section('content')
<div class="row g-5 g-xl-8">
    <div class="col-xl-8">
        <div class="card border border-gray-200 shadow-sm">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="fw-bold m-0 text-gray-900">Perbarui Profil Perusahaan</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-solid" name="namaPerusahaan" value="{{ old('namaPerusahaan', $profil->namaPerusahaan ?? 'Coretech Studio') }}" required />
                    </div>

                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Alamat Kantor / Studio</label>
                        <textarea class="form-control form-control-solid" rows="3" name="alamat" required>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="required fs-6 fw-semibold mb-2">Email Bisnis</label>
                            <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email', $profil->email ?? '') }}" required />
                        </div>
                        <div class="col-md-6">
                            <label class="required fs-6 fw-semibold mb-2">Nomor Telepon / WhatsApp</label>
                            <input type="text" class="form-control form-control-solid" name="nomorTelepon" value="{{ old('nomorTelepon', $profil->nomorTelepon ?? '') }}" required />
                        </div>
                    </div>

                    <div class="separator separator-dashed my-6"></div>
                    <h4 class="fw-bold text-gray-800 mb-4">Akun Media Sosial</h4>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-3">
                            <label class="fs-6 fw-semibold mb-2">Instagram</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="ki-duotone ki-instagram fs-4"></i></span>
                                <input type="text" class="form-control form-control-solid" name="instagram" value="{{ old('instagram', $profil->instagram ?? '') }}" placeholder="@coretech.id atau link" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fs-6 fw-semibold mb-2">TikTok</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="ki-duotone ki-music fs-4"></i></span>
                                <input type="text" class="form-control form-control-solid" name="tiktok" value="{{ old('tiktok', $profil->tiktok ?? '') }}" placeholder="@coretech_dev" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-3">
                            <label class="fs-6 fw-semibold mb-2">Threads</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control form-control-solid" name="treads" value="{{ old('treads', $profil->treads ?? '') }}" placeholder="@coretech.id" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fs-6 fw-semibold mb-2">LinkedIn</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="ki-duotone ki-linkedin fs-4"></i></span>
                                <input type="text" class="form-control form-control-solid" name="linkedIN" value="{{ old('linkedIN', $profil->linkedIN ?? '') }}" placeholder="linkedin.com/company/coretech" />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-check fs-2 me-1"></i> Simpan Profil Perusahaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Card -->
    <div class="col-xl-4">
        <div class="card border border-gray-200 shadow-sm">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="fw-bold m-0 text-gray-900">Kartu Preview Identitas</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-50px symbol-circle me-3">
                        <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                            {{ strtoupper(substr($profil->namaPerusahaan ?? 'C', 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-gray-900 fw-bold mb-0">{{ $profil->namaPerusahaan ?? 'Coretech Studio' }}</h4>
                        <span class="text-muted fs-8 font-monospace">{{ $profil->uuid ?? 'Auto-generated UUID' }}</span>
                    </div>
                </div>

                <div class="separator separator-dashed my-4"></div>

                <div class="mb-3">
                    <span class="text-muted fs-8 text-uppercase fw-bold">Alamat:</span>
                    <p class="text-gray-800 fw-semibold fs-7 mb-0">{{ $profil->alamat ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <span class="text-muted fs-8 text-uppercase fw-bold">Email Bisnis:</span>
                    <p class="text-gray-800 fw-semibold fs-7 mb-0">{{ $profil->email ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <span class="text-muted fs-8 text-uppercase fw-bold">Kontak / Telepon:</span>
                    <p class="text-gray-800 fw-semibold fs-7 mb-0">{{ $profil->nomorTelepon ?? '-' }}</p>
                </div>

                <div class="separator separator-dashed my-4"></div>

                <div class="d-flex flex-column gap-2">
                    <span class="text-muted fs-8 text-uppercase fw-bold">Media Sosial:</span>
                    <div class="d-flex flex-wrap gap-2">
                        @if($profil->instagram ?? false)
                            <span class="badge badge-light-danger fs-8">IG: {{ $profil->instagram }}</span>
                        @endif
                        @if($profil->tiktok ?? false)
                            <span class="badge badge-light-dark fs-8">TikTok: {{ $profil->tiktok }}</span>
                        @endif
                        @if($profil->treads ?? false)
                            <span class="badge badge-light-info fs-8">Threads: {{ $profil->treads }}</span>
                        @endif
                        @if($profil->linkedIN ?? false)
                            <span class="badge badge-light-primary fs-8">LinkedIn: {{ $profil->linkedIN }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
