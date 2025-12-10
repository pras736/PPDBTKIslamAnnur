@extends('layouts.adminlte')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-gradient-indigo">
            <div class="inner">
                <p class="text-uppercase fw-semibold mb-1">Total Murid</p>
                <h3 class="mb-0">{{ $totalMurid }}</h3>
                <small class="opacity-75">Semua murid terdaftar</small>
            </div>
            <div class="icon">
                <i class="fas fa-children"></i>
            </div>
            <a href="{{ route('admin.murid.index') }}" class="small-box-footer">
                Lihat murid <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-gradient-warning text-dark">
            <div class="inner">
                <p class="text-uppercase fw-semibold mb-1">Pendaftar</p>
                <h3 class="mb-0">{{ $totalPendaftar }}</h3>
                <small class="opacity-75">Menunggu verifikasi</small>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{ route('admin.murid.index', ['status' => 'pendaftar']) }}" class="small-box-footer text-dark">
                Lihat pendaftar <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-gradient-emerald">
            <div class="inner">
                <p class="text-uppercase fw-semibold mb-1">Terdaftar</p>
                <h3 class="mb-0">{{ $totalTerdaftar }}</h3>
                <small class="opacity-75">Sudah menjadi siswa</small>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
            <a href="{{ route('admin.murid.index', ['status' => 'terdaftar']) }}" class="small-box-footer">
                Lihat siswa <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-gradient-rose">
            <div class="inner">
                <p class="text-uppercase fw-semibold mb-1">Pembayaran Menunggu</p>
                <h3 class="mb-0">{{ $totalPembayaranMenunggu }}</h3>
                <small class="opacity-75">Butuh verifikasi admin</small>
            </div>
            <div class="icon">
                <i class="fas fa-receipt"></i>
            </div>
            <a href="{{ route('admin.pembayaran.index', ['status_pembayaran' => 'menunggu']) }}" class="small-box-footer">
                Periksa pembayaran <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card card-outline card-success h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Distribusi Murid</h5>
            </div>
            <div class="card-body">
                <canvas id="chartMurid"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card card-outline card-info h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Pembayaran</h5>
            </div>
            <div class="card-body">
                <canvas id="chartPembayaran"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const dataMurid = {
        labels: ['Pendaftar', 'Terdaftar'],
        datasets: [{
            label: 'Jumlah Murid',
            data: [{{ $totalPendaftar }}, {{ $totalTerdaftar }}],
            backgroundColor: [
                'rgba(255, 193, 7, 0.6)',
                'rgba(16, 185, 129, 0.6)'
            ],
            borderColor: [
                'rgba(255, 193, 7, 1)',
                'rgba(16, 185, 129, 1)'
            ],
            borderWidth: 2,
            borderRadius: 6
        }]
    };

    const dataPembayaran = {
        labels: ['Menunggu', 'Lainnya'],
        datasets: [{
            data: [{{ $totalPembayaranMenunggu }}, Math.max({{ $totalMurid }} - {{ $totalPembayaranMenunggu }}, 0)],
            backgroundColor: [
                'rgba(59, 130, 246, 0.7)',
                'rgba(148, 163, 184, 0.5)'
            ],
            borderColor: [
                'rgba(59, 130, 246, 1)',
                'rgba(148, 163, 184, 1)'
            ],
            borderWidth: 1
        }]
    };

    new Chart(document.getElementById('chartMurid'), {
        type: 'bar',
        data: dataMurid,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => `${ctx.parsed.y} murid` } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision:0 }
                }
            }
        }
    });

    new Chart(document.getElementById('chartPembayaran'), {
        type: 'doughnut',
        data: dataPembayaran,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed} pembayaran` } }
            },
            cutout: '60%'
        }
    });
</script>
@endpush

@endsection


