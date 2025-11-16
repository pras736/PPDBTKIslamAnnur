@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tambah Kelas Baru</h2>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Form Tambah Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: Kelompok A" required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="id_guru" class="form-label">Wali Kelas (Guru)</label>
                            <select class="form-select @error('id_guru') is-invalid @enderror" id="id_guru" name="id_guru">
                                <option value="">Pilih Guru (Opsional)</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_guru }}" {{ old('id_guru') == $guru->id_guru ? 'selected' : '' }}>
                                        {{ $guru->akun->username ?? '-' }} - {{ $guru->NIP }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_guru" class="form-label">Nama Guru</label>
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" placeholder="Opsional">
                            @error('nama_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jika tidak memilih wali kelas, isi manual nama guru</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-brand">Simpan</button>
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

