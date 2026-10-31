@extends('admin.layout')

@section('title', 'Manajemen QA & Testimoni')
@section('page_title', 'Tanya Jawab (QA) & Testimoni')
@section('page_subtitle', 'Kelola pertanyaan, jawaban, dan ulasan kepuasan klien untuk ditampilkan di landing page')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">Daftar Tanya Jawab / Review Klien</h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahQA">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah QA
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-180px">Nama Klien / Penanya</th>
                        <th class="min-w-150px">Perusahaan / Organisasi</th>
                        <th class="min-w-300px">Keterangan / Ulasan / Pertanyaan</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($qas as $qa)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px symbol-circle me-3">
                                        <div class="symbol-label fs-5 fw-bold bg-light-primary text-primary">
                                            {{ strtoupper(substr($qa->nama, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-900 fw-bold fs-6">{{ $qa->nama }}</span>
                                        <span class="text-muted fs-8 font-monospace">{{ $qa->uuid }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-dark fs-7 fw-bold">{{ $qa->perusahaan }}</span>
                            </td>
                            <td>
                                <p class="mb-0 text-gray-700 fs-7">
                                    {{ $qa->keterangan }}
                                </p>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditQA{{ $qa->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.qa.destroy', $qa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus QA dari {{ $qa->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit QA -->
                        <div class="modal fade" id="modalEditQA{{ $qa->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.qa.update', $qa->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit Tanya Jawab (QA)</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Klien / Penanya</label>
                                                <input type="text" class="form-control form-control-solid" name="nama" value="{{ old('nama', $qa->nama) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Perusahaan / Brand</label>
                                                <input type="text" class="form-control form-control-solid" name="perusahaan" value="{{ old('perusahaan', $qa->perusahaan) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Keterangan / Ulasan / Jawaban</label>
                                                <textarea class="form-control form-control-solid" rows="5" name="keterangan" required>{{ old('keterangan', $qa->keterangan) }}</textarea>
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
                            <td colspan="4" class="text-center py-8 text-muted">Belum ada data QA / Testimoni yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $qas->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah QA -->
<div class="modal fade" id="modalTambahQA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form action="{{ route('admin.qa.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah QA Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Nama Klien / Penanya</label>
                        <input type="text" class="form-control form-control-solid" name="nama" placeholder="Contoh: Budi Santoso" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Perusahaan / Brand</label>
                        <input type="text" class="form-control form-control-solid" name="perusahaan" placeholder="Contoh: PT Finansial Maju Jaya" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Keterangan / Ulasan / Pertanyaan</label>
                        <textarea class="form-control form-control-solid" rows="5" name="keterangan" placeholder="Tuliskan ulasan pengalaman kerja sama atau FAQ..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah QA</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
