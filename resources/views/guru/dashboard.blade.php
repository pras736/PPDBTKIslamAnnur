@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Dashboard Guru</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Data Kelas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Nama Guru</th>
                                <th>Jumlah Murid</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $k)
                                <tr>
                                    <td>{{ $k->nama_kelas }}</td>
                                    <td>{{ $k->nama_guru ?? ($k->guru->NIP ?? '-') }}</td>
                                    <td>{{ $k->murids->count() ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('guru.kelas.show', $k->id_kelas) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data kelas</td>
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

