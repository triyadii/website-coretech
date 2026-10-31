@extends('admin.layout')

@section('title', 'Master Kategori Portofolio')
@section('page_title', 'Master Kategori Portofolio')
@section('page_subtitle', 'Kelola kategori dan klasifikasi industri proyek portofolio teknologi')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <form action="{{ route('admin.kategori-portofolio.index') }}" method="GET">
                    <input type="text" name="search" class="form-control form-control-solid w-250px ps-13" 
                           placeholder="Cari kategori..." value="{{ request('search') }}" />
                </form>
            </div>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-200px">Nama Kategori</th>
                        <th class="min-w-150px">Slug</th>
                        <th class="min-w-220px">Keterangan</th>
                        <th class="min-w-120px text-center">Jumlah Portofolio</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="bullet bullet-vertical h-35px me-3" style="background-color: {{ $kategori->warna ?: '#a78bfa' }};"></span>
                                    <div>
                                        <span class="text-gray-900 fw-bold fs-6">{{ $kategori->nama }}</span>
                                        <div class="text-muted fs-8 font-monospace">{{ $kategori->uuid }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-primary fw-semibold fs-7 font-monospace">
                                    {{ $kategori->slug }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray-700 fs-7">
                                    {{ \Illuminate\Support\Str::limit($kategori->keterangan ?? '-', 80) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light-success fs-7 fw-bold px-3 py-2">
                                    {{ $kategori->portofolios_count ?? $kategori->portofolios()->count() }} Proyek
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                                        data-bs-toggle="modal" data-bs-target="#modalEditKategori{{ $kategori->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.kategori-portofolio.destroy', $kategori->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}? Portofolio terkait tidak akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Kategori -->
                        <div class="modal fade" id="modalEditKategori{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-600px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.kategori-portofolio.update', $kategori->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit Master Kategori Portofolio</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                                                <input type="text" class="form-control form-control-solid" name="nama" 
                                                       value="{{ old('nama', $kategori->nama) }}" required />
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Aksen Warna Badge</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <input type="color" class="form-control form-control-color w-60px" 
                                                           name="warna" value="{{ old('warna', $kategori->warna ?: '#a78bfa') }}">
                                                    <span class="text-muted fs-7">Warna penanda kategori pada kartu portofolio</span>
                                                </div>
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Keterangan / Cakupan Proyek</label>
                                                <textarea class="form-control form-control-solid" rows="3" name="keterangan" 
                                                          placeholder="Jelaskan ringkas tipe proyek dalam kategori ini...">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer flex-center">
                                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-muted">
                                Belum ada master kategori portofolio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            {{ $kategoris->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <form action="{{ route('admin.kategori-portofolio.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Master Kategori Portofolio</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" name="nama" 
                               placeholder="Contoh: Fintech & Digital Banking" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Aksen Warna Badge</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" class="form-control form-control-color w-60px" name="warna" value="#a78bfa">
                            <span class="text-muted fs-7">Warna penanda kategori pada kartu portofolio</span>
                        </div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Keterangan / Cakupan Proyek</label>
                        <textarea class="form-control form-control-solid" rows="3" name="keterangan" 
                                  placeholder="Jelaskan ringkas cakupan solusi teknologi dalam kategori ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
