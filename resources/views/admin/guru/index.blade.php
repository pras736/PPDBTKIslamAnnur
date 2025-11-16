@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Guru</h2>
            <div>
                <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Guru
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
                                <th>NIP</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gurus as $index => $guru)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $guru->NIP }}</td>
                                    <td>
                                        <strong>{{ $guru->akun->username ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        @if($guru->akun)
                                            @if($guru->akun->password_plain)
                                                <code class="text-success">{{ $guru->akun->password_plain }}</code>
                                            @else
                                                <span class="text-warning">Belum di-set</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $guru->kelas ?? '-' }}</td>
                                    <td>
                                        @if($guru->kelas)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.guru.edit', $guru->id_guru) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.guru.reset-password', $guru->id_guru) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info" onclick="return confirm('Reset password menjadi: guru123?')">
                                                <i class="bi bi-key"></i> Reset Password
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.guru.destroy', $guru->id_guru) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                    <td colspan="7" class="text-center">Tidak ada data guru</td>
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

