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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

