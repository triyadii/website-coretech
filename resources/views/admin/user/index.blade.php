@extends('admin.layout')

@section('title', 'Manajemen Pengguna Admin')
@section('page_title', 'Manajemen User')
@section('page_subtitle', 'Kelola akun administrator pengelola sistem dan hak akses')

@section('content')
<div class="card border border-gray-200 shadow-sm">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0 text-gray-900">Daftar Pengguna Administrator</h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah User
            </button>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-200px">Nama & UUID</th>
                        <th class="min-w-150px">Username</th>
                        <th class="min-w-150px">Email</th>
                        <th class="min-w-100px">Terdaftar Sejak</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px symbol-circle me-3">
                                        <div class="symbol-label fs-5 fw-bold bg-light-danger text-danger">
                                            {{ strtoupper(substr($user->nama ?? $user->username, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-gray-900 fw-bold fs-6">{{ $user->nama ?? $user->name }}</span>
                                            @if($user->id === Auth::id())
                                                <span class="badge badge-light-primary fs-8">Anda</span>
                                            @endif
                                        </div>
                                        <span class="text-muted fs-8 font-monospace">{{ $user->uuid }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-dark fs-7 font-monospace fw-bold">{{ $user->username }}</span>
                            </td>
                            <td>
                                <span class="text-gray-700 fs-7">{{ $user->email ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="text-muted fs-7">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $user->id }}" title="Edit">
                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user {{ $user->username }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Edit User -->
                        <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-600px">
                                <div class="modal-content">
                                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Edit User Administrator</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                            </div>
                                        </div>
                                        <div class="modal-body py-10 px-lg-17">
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                                                <input type="text" class="form-control form-control-solid" name="nama" value="{{ old('nama', $user->nama ?? $user->name) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="required fs-6 fw-semibold mb-2">Username</label>
                                                <input type="text" class="form-control form-control-solid" name="username" value="{{ old('username', $user->username) }}" required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Email (Opsional)</label>
                                                <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email', $user->email) }}" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="fs-6 fw-semibold mb-2">Ganti Password (Kosongkan jika tidak diubah)</label>
                                                <input type="password" class="form-control form-control-solid" name="password" placeholder="Minimal 6 karakter" />
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
                            <td colspan="5" class="text-center py-8 text-muted">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah User Administrator</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-solid" name="nama" placeholder="Contoh: Administrator Utama" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Username</label>
                        <input type="text" class="form-control form-control-solid" name="username" placeholder="Contoh: admin2" required />
                    </div>
                    <div class="mb-5">
                        <label class="required fs-6 fw-semibold mb-2">Password</label>
                        <input type="password" class="form-control form-control-solid" name="password" placeholder="Minimal 6 karakter" required />
                    </div>
                    <div class="mb-5">
                        <label class="fs-6 fw-semibold mb-2">Email (Opsional)</label>
                        <input type="email" class="form-control form-control-solid" name="email" placeholder="admin@coretech.id" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
