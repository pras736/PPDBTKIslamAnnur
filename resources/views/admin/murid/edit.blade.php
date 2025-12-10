@extends('layouts.adminlte')

@section('title', 'Edit Murid')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Data Murid</h2>
            <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Form Edit Murid</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.murid.update', $murid->id_murid) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="mb-3">Data Akun</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ $murid->akun->username ?? '-' }}" disabled>
                            <small class="text-muted">Username tidak dapat diubah</small>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="password" value="{{ $murid->akun->password_plain ?? '-' }}" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="copyPassword('{{ $murid->akun->password_plain ?? '' }}')">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                            <small class="text-muted">Password saat ini</small>
                        </div>
                    </div>

                    <h6 class="mb-3">Data Murid</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status_siswa" class="form-label">Status Siswa <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_siswa') is-invalid @enderror" id="status_siswa" name="status_siswa" required>
                                <option value="pendaftar" {{ old('status_siswa', $murid->status_siswa) === 'pendaftar' ? 'selected' : '' }}>Pendaftar</option>
                                <option value="terdaftar" {{ old('status_siswa', $murid->status_siswa) === 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                            </select>
                            @error('status_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $murid->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nik_anak" class="form-label">NIK Anak</label>
                            <input type="text" class="form-control @error('nik_anak') is-invalid @enderror" id="nik_anak" name="nik_anak" value="{{ old('nik_anak', $murid->nik_anak) }}" maxlength="20">
                            @error('nik_anak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L" {{ old('jenis_kelamin', $murid->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $murid->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $murid->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $murid->tanggal_lahir ? $murid->tanggal_lahir->format('Y-m-d') : '') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-brand">Update</button>
                            <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
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

