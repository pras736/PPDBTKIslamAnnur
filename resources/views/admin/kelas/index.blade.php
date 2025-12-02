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
                <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                        <label for="status_wali" class="form-label">Filter Status Wali Kelas</label>
                        <select name="status_wali" id="status_wali" class="form-select">
                            <option value="all" {{ request('status_wali') === 'all' || !request()->has('status_wali') ? 'selected' : '' }}>Semua</option>
                            <option value="sudah" {{ request('status_wali') === 'sudah' ? 'selected' : '' }}>Sudah punya wali kelas</option>
                            <option value="belum" {{ request('status_wali') === 'belum' ? 'selected' : '' }}>Belum punya wali kelas</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Terapkan</button>
                        @if(request()->has('status_wali') && request('status_wali') !== 'all')
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </form>

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
                            @forelse($kelas as $kelasItem)
                                <tr>
                                    <td>
                                        @if($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            {{ $kelas->firstItem() + $loop->index }}
                                        @else
                                            {{ $loop->iteration }}
                                        @endif
                                    </td>
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

                    @if($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-3">
                            {{ $kelas->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

