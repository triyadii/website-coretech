@extends('admin.layout')

@section('title', 'Manajemen Master Jasa & Harga')
@section('page_title', 'Master Jasa & Harga')
@section('page_subtitle', 'Kelola paket layanan, penawaran solusi software, dan estimasi biaya')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">Daftar Paket Jasa & Layanan</h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJasa">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Master Jasa
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-200px">Nama Layanan / Jasa</th>
                        <th class="min-w-150px">Harga (IDR)</th>
                        <th class="min-w-150px">UUID</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($jasas as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px symbol-circle me-3">
                                        <div class="symbol-label fs-5 fw-bold bg-light-warning text-warning">
                                            <i class="ki-duotone ki-code fs-3 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                        </div>
                                    </div>
                                    <span class="text-gray-900 fw-bold fs-6">{{ $item->jasa }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-success fs-6 fw-bold">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted fs-8 font-monospace">{{ $item->uuid }}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditJasa{{ $item->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.master-jasa.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jasa {{ $item->jasa }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Jasa -->
                        <div class="modal fade" id="modalEditJasa{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-600px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.master-jasa.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit Master Jasa</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Layanan / Jasa</label>
                                                <input type="text" class="form-control form-control-solid" name="jasa" value="{{ old('jasa', $item->jasa) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Harga (Rupiah)</label>
                                                <input type="number" class="form-control form-control-solid" name="harga" value="{{ old('harga', $item->harga) }}" min="0" step="1000" required />
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
                            <td colspan="4" class="text-center py-8 text-muted">Belum ada paket jasa yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $jasas->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Jasa -->
<div class="modal fade" id="modalTambahJasa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <form action="{{ route('admin.master-jasa.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Master Jasa Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Nama Layanan / Jasa</label>
                        <input type="text" class="form-control form-control-solid" name="jasa" placeholder="Contoh: Custom Web Application Enterprise" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Harga (Rupiah)</label>
                        <input type="number" class="form-control form-control-solid" name="harga" placeholder="Contoh: 15000000" min="0" step="1000" required />
                        <div class="form-text">Masukkan angka tanpa titik atau koma (contoh: 25000000).</div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Jasa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
