@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Bukti Pembayaran</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                        <label for="status_pembayaran" class="form-label">Filter Status Pembayaran</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                            <option value="all" {{ request('status_pembayaran') === 'all' || !request()->has('status_pembayaran') ? 'selected' : '' }}>Semua</option>
                            <option value="menunggu" {{ request('status_pembayaran') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diverifikasi" {{ request('status_pembayaran') === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="ditolak" {{ request('status_pembayaran') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                id="search"
                                class="form-control"
                                placeholder="Cari ID pembayaran, ID murid, atau nama murid"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        @if(request()->has('status_pembayaran') || request()->filled('search'))
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary me-2">Reset</a>
                        @endif
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>ID Murid</th>
                                <th>Nama Murid</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->id_pembayaran }}</td>
                                    <td>{{ $pembayaran->id_murid }}</td>
                                    <td>{{ $pembayaran->murid->nama_lengkap ?? '-' }}</td>
                                    <td>
                                        @if($pembayaran->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pembayaran->status_pembayaran === 'diverifikasi')
                                            <span class="badge bg-success">Diverifikasi</span>
                                        @elseif($pembayaran->status_pembayaran === 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pembayaran->status_pembayaran !== 'diverifikasi')
                                            <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id_pembayaran) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Verifikasi</button>
                                            </form>
                                        @endif
                                        @if($pembayaran->status_pembayaran !== 'ditolak')
                                            <form action="{{ route('admin.pembayaran.tolak', $pembayaran->id_pembayaran) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($pembayarans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pembayarans->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

