@extends('admin.layout')

@section('title', 'Manajemen Berita')
@section('page_title', 'Berita & Artikel')
@section('page_subtitle', 'Publikasi artikel teknologi, insight software engineering, dan update perusahaan')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">Daftar Berita & Artikel</h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Berita
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-80px">Gambar</th>
                        <th class="min-w-200px">Judul Berita</th>
                        <th class="min-w-300px">Keterangan / Isi</th>
                        <th class="min-w-100px">Status</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($beritas as $item)
                        <tr>
                            <td>
                                @if($item->gambar)
                                    <div class="symbol symbol-50px symbol-2by3">
                                        <img src="{{ $item->gambar }}" alt="Gambar Berita" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=150&q=80'" />
                                    </div>
                                @else
                                    <div class="symbol symbol-50px symbol-2by3 bg-light">
                                        <span class="symbol-label text-muted fs-8">No Img</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-900 fw-bold fs-6">{{ $item->judul }}</span>
                                    <span class="text-muted fs-8 font-monospace">{{ $item->uuid }}</span>
                                    <span class="text-muted fs-8 mt-1"><i class="ki-duotone ki-calendar fs-8 me-1"><span class="path1"></span><span class="path2"></span></i> {{ $item->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 text-gray-700 fs-7" style="max-width: 350px;">
                                    {{ Str::limit(strip_tags($item->keterangan), 140) }}
                                </p>
                            </td>
                            <td>
                                @if($item->status === 'published')
                                    <span class="badge badge-light-success fs-7 fw-bold">Published</span>
                                @else
                                    <span class="badge badge-light-warning fs-7 fw-bold">Draft</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditBerita{{ $item->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita: {{ $item->judul }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Berita -->
                        <div class="modal fade" id="modalEditBerita{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-700px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit Berita & Artikel</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Judul Berita</label>
                                                <input type="text" class="form-control form-control-solid" name="judul" value="{{ old('judul', $item->judul) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Status Publikasi</label>
                                                <select class="form-select form-select-solid" name="status" required>
                                                    <option value="published" {{ $item->status === 'published' ? 'selected' : '' }}>Published (Tampil di Landing Page)</option>
                                                    <option value="draft" {{ $item->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                                </select>
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Keterangan / Konten Berita</label>
                                                <textarea class="form-control form-control-solid" rows="6" name="keterangan" required>{{ old('keterangan', $item->keterangan) }}</textarea>
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Ganti Gambar (Cukup 1 Gambar)</label>
                                                <input type="file" class="form-control form-control-solid" name="gambar_file" accept="image/*" />
                                                <div class="form-text">Format: JPG, PNG, WebP (maks 2MB).</div>
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Atau URL Gambar</label>
                                                <input type="url" class="form-control form-control-solid" name="gambar_url" value="{{ old('gambar_url', $item->gambar) }}" placeholder="https://example.com/cover.jpg" />
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
                            <td colspan="5" class="text-center py-8 text-muted">Belum ada berita yang dipublikasikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $beritas->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-700px">
        <div class="modal-content">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Berita Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Judul Berita</label>
                        <input type="text" class="form-control form-control-solid" name="judul" placeholder="Contoh: Coretech Merilis Arsitektur Microservices Baru" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Status Publikasi</label>
                        <select class="form-select form-select-solid" name="status" required>
                            <option value="published" selected>Published (Tampil di Landing Page)</option>
                            <option value="draft">Draft (Sembunyikan)</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Keterangan / Konten Berita</label>
                        <textarea class="form-control form-control-solid" rows="6" name="keterangan" placeholder="Tuliskan isi berita, analisis, atau pengumuman lengkap..." required></textarea>
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Upload Gambar (Cukup 1 Gambar)</label>
                        <input type="file" class="form-control form-control-solid" name="gambar_file" accept="image/*" />
                        <div class="form-text">Format: JPG, PNG, WebP (maks 2MB).</div>
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Atau URL Gambar</label>
                        <input type="url" class="form-control form-control-solid" name="gambar_url" placeholder="https://images.unsplash.com/..." />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Publikasikan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
