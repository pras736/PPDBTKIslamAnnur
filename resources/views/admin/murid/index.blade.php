@extends('layouts.app')

@section('title', 'Manajemen Murid')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Murid</h2>
            <div>
                <a href="{{ route('admin.export.murid') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.murid.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Murid
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($murids as $index => $murid)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $murid->nama_lengkap }}</td>
                                    <td>{{ $murid->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        @if($murid->status_siswa === 'terdaftar')
                                            <span class="badge bg-success">Terdaftar</span>
                                        @else
                                            <span class="badge bg-warning">Pendaftar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($murid->pembayaranTerbaru)
                                            @if($murid->pembayaranTerbaru->status_pembayaran === 'diverifikasi')
                                                <span class="badge bg-success">Diverifikasi</span>
                                            @elseif($murid->pembayaranTerbaru->status_pembayaran === 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Menunggu</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $murid->akun->username ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        @if($murid->akun)
                                            @if($murid->akun->password_plain)
                                                <code class="text-success">{{ $murid->akun->password_plain }}</code>
                                            @else
                                                <span class="text-warning">Belum di-set</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.murid.show', $murid->id_murid) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.murid.edit', $murid->id_murid) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.murid.reset-password', $murid->id_murid) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Reset password menjadi: password123?')">
                                                <i class="bi bi-key"></i> Reset Password
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.murid.destroy', $murid->id_murid) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data murid</td>
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

