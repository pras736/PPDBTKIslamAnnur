@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Dashboard Admin</h2>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Murid</h5>
                <h2>{{ $totalMurid }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pendaftar</h5>
                <h2>{{ $totalPendaftar }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Terdaftar</h5>
                <h2>{{ $totalTerdaftar }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Pembayaran Menunggu</h5>
                <h2>{{ $totalPembayaranMenunggu }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Menu Admin</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-receipt"></i> Manajemen Pembayaran
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-people"></i> Manajemen Murid
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-badge"></i> Manajemen Guru
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-book"></i> Manajemen Kelas
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.export.murid') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-file-earmark-excel"></i> Export Data Murid
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

