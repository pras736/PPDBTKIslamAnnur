@extends('layouts.adminlte')

@section('title', 'Detail Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Kelas: {{ $kelas->nama_kelas }}</h2>
            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Informasi Kelas</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama Kelas:</strong> {{ $kelas->nama_kelas }}</p>
                <p><strong>Nama Guru:</strong> {{ $kelas->nama_guru ?? ($kelas->guru->NIP ?? '-') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Daftar Murid</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Nama Panggilan</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Status Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($murids as $index => $murid)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $murid->nama_lengkap }}</td>
                                    <td>{{ $murid->nama_panggilan ?? '-' }}</td>
                                    <td>{{ $murid->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $murid->tanggal_lahir ? $murid->tanggal_lahir->format('d-m-Y') : '-' }}</td>
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
                                        <span class="badge {{ $murid->status_siswa === 'terdaftar' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($murid->status_siswa) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada murid di kelas ini</td>
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

