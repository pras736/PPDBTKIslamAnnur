@extends('layouts.adminlte')

@section('title', 'Detail Murid')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Murid</h2>
            <div>
                <form action="{{ route('admin.murid.reset-password', $murid->id_murid) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info" onclick="return confirm('Reset password menjadi: password123?')">
                        <i class="bi bi-key"></i> Reset Password
                    </button>
                </form>
                <a href="{{ route('admin.murid.edit', $murid->id_murid) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Data Identitas</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Nama Lengkap</th>
                        <td>: {{ $murid->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>Nama Panggilan</th>
                        <td>: {{ $murid->nama_panggilan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK Anak</th>
                        <td>: {{ $murid->nik_anak ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>: {{ $murid->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>: {{ $murid->tempat_lahir }}, {{ $murid->tanggal_lahir ? $murid->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>: {{ $murid->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Siswa</th>
                        <td>: 
                            @if($murid->status_siswa === 'terdaftar')
                                <span class="badge bg-success">Terdaftar</span>
                            @else
                                <span class="badge bg-warning">Pendaftar</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Data Alamat</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Alamat</th>
                        <td>: {{ $murid->alamat_jalan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kelurahan</th>
                        <td>: {{ $murid->alamat_kelurahan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>: {{ $murid->alamat_kecamatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td>: {{ $murid->alamat_kota ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>: {{ $murid->alamat_provinsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kode Pos</th>
                        <td>: {{ $murid->kode_pos ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Data Orang Tua</h5>
            </div>
            <div class="card-body">
                <h6>Ayah</h6>
                <table class="table table-borderless mb-3">
                    <tr>
                        <th width="40%">Nama</th>
                        <td>: {{ $murid->nama_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ $murid->nik_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>: {{ $murid->pekerjaan_ayah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>: {{ $murid->telp_ayah ?? '-' }}</td>
                    </tr>
                </table>
                
                <h6>Ibu</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Nama</th>
                        <td>: {{ $murid->nama_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ $murid->nik_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>: {{ $murid->pekerjaan_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>: {{ $murid->telp_ibu ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Data Akun & Pembayaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Username</th>
                        <td>: <strong>{{ $murid->akun->username ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>: 
                            @if($murid->akun && $murid->akun->password_plain)
                                <code class="text-success">{{ $murid->akun->password_plain }}</code>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="copyPassword('{{ $murid->akun->password_plain }}')">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>: 
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
                    </tr>
                </table>

                @if($murid->pembayarans->count() > 0)
                    <h6 class="mt-3">Riwayat Pembayaran</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($murid->pembayarans as $pembayaran)
                                    <tr>
                                        <td>{{ $pembayaran->created_at->format('d-m-Y') }}</td>
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
                                            @if($pembayaran->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyPassword(password) {
    if (password && password !== '-') {
        navigator.clipboard.writeText(password).then(function() {
            alert('Password berhasil disalin!');
        });
    }
}
</script>
@endsection

