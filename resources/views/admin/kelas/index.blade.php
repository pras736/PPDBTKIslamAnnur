@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Kelas</h2>
            <div>
                <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kelas
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
                                <th>Nama Kelas</th>
                                <th>Nama Guru</th>
                                <th>Wali Kelas</th>
                                <th>Jumlah Murid</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $index => $kelasItem)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kelasItem->nama_kelas }}</td>
                                    <td>{{ $kelasItem->nama_guru ?? '-' }}</td>
                                    <td>
                                        @if($kelasItem->guru)
                                            <span class="badge bg-success">{{ $kelasItem->guru->akun->username ?? '-' }}</span>
                                        @else
                                            <span class="badge bg-secondary">Belum ditentukan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $kelasItem->murids->count() ?? 0 }} Murid</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.kelas.edit', $kelasItem->id_kelas) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Edit & Assign Murid
                                        </a>
                                        <form action="{{ route('admin.kelas.destroy', $kelasItem->id_kelas) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
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
                                    <td colspan="6" class="text-center">Tidak ada data kelas</td>
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

