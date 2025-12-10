@extends('layouts.adminlte')

@section('title', 'Edit Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Data Guru</h2>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Form Edit Guru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.guru.update', $guru->id_guru) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ $guru->akun->username ?? '-' }}" disabled>
                            <small class="text-muted">Username tidak dapat diubah</small>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="password" value="{{ $guru->akun->password_plain ?? '-' }}" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="copyPassword('{{ $guru->akun->password_plain ?? '' }}')">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                            <small class="text-muted">Password saat ini</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="NIP" class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('NIP') is-invalid @enderror" id="NIP" name="NIP" value="{{ old('NIP', $guru->NIP) }}" required>
                            @error('NIP')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $guru->kelas) }}" placeholder="Opsional">
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-brand">Update</button>
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
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

