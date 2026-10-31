@extends('admin.layout')

@section('title', 'Manajemen Portofolio')
@section('page_title', 'Portofolio')
@section('page_subtitle', 'Kelola daftar karya dan showcase proyek digital software house')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">Daftar Portofolio Proyek</h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPortofolio">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Portofolio
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-150px">Nama Proyek</th>
                        <th class="min-w-200px">Keterangan</th>
                        <th class="min-w-120px">Link Proyek</th>
                        <th class="min-w-140px">Foto (Maks. 3)</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($portofolios as $item)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-900 fw-bold fs-6">{{ $item->nama }}</span>
                                    <span class="text-muted fs-8 font-monospace">{{ $item->uuid }}</span>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 text-gray-700 fs-7" style="max-width: 320px;">
                                    {{ Str::limit($item->keterangan, 120) }}
                                </p>
                            </td>
                            <td>
                                @if($item->link)
                                    <a href="{{ $item->link }}" target="_blank" class="btn btn-sm btn-light-primary py-1 px-3 fs-8">
                                        <i class="ki-duotone ki-exit-right-corner fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                                        Buka Link
                                    </a>
                                @else
                                    <span class="badge badge-light-secondary fs-8">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    @if(is_array($item->foto) && count($item->foto) > 0)
                                        @foreach(array_slice($item->foto, 0, 3) as $imgUrl)
                                            <a href="{{ $imgUrl }}" target="_blank" class="symbol symbol-40px symbol-2by3">
                                                <img src="{{ $imgUrl }}" alt="Foto" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=100&q=80'" />
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted fs-8">Tidak ada foto</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditPortofolio{{ $item->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.portofolio.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus portofolio {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Portofolio -->
                        <div class="modal fade" id="modalEditPortofolio{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.portofolio.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit Portofolio</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Proyek</label>
                                                <input type="text" class="form-control form-control-solid" name="nama" value="{{ old('nama', $item->nama) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Keterangan / Deskripsi</label>
                                                <textarea class="form-control form-control-solid" rows="4" name="keterangan" required>{{ old('keterangan', $item->keterangan) }}</textarea>
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Link Proyek / Website</label>
                                                <input type="url" class="form-control form-control-solid" name="link" value="{{ old('link', $item->link) }}" placeholder="https://example.com" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Upload Foto Baru (Maksimal 3)</label>
                                                <input type="file" class="form-control form-control-solid" name="foto_files[]" multiple accept="image/*" />
                                                <div class="form-text">Pilih 1 hingga 3 foto (JPEG, PNG, WebP).</div>
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Atau URL Foto (1 URL per baris, maks 3)</label>
                                                <textarea class="form-control form-control-solid font-monospace fs-7" rows="3" name="foto_urls" placeholder="https://domain.com/photo1.jpg">{{ is_array($item->foto) ? implode("\n", $item->foto) : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer flex-center">
                                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-muted">Belum ada portofolio yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $portofolios->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Portofolio -->
<div class="modal fade" id="modalTambahPortofolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form action="{{ route('admin.portofolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Portofolio Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Nama Proyek</label>
                        <input type="text" class="form-control form-control-solid" name="nama" placeholder="Contoh: FinTech Mobile App" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Keterangan / Deskripsi</label>
                        <textarea class="form-control form-control-solid" rows="4" name="keterangan" placeholder="Penjelasan tentang teknologi, solusi, dan hasil..." required></textarea>
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Link Proyek / Website</label>
                        <input type="url" class="form-control form-control-solid" name="link" placeholder="https://example.com" />
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Upload Foto (Maksimal 3 foto)</label>
                        <input type="file" class="form-control form-control-solid" name="foto_files[]" multiple accept="image/*" />
                        <div class="form-text">Unggah foto tampilan aplikasi atau mockup (maks 3 file).</div>
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Atau Masukkan URL Foto (1 baris per URL)</label>
                        <textarea class="form-control form-control-solid font-monospace fs-7" rows="3" name="foto_urls" placeholder="https://images.unsplash.com/..."></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Portofolio</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
