<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Murid Baru - TK Islam Annur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root {
            --brand: #16a34a;
            --brand-700: #15803d;
            --muted: #6b7280;
        }
        .bg-brand { background-color: var(--brand) !important; }
        .text-brand { color: var(--brand) !important; }
        .btn-brand { background-color: var(--brand); border-color: var(--brand); color: #fff; }
        .btn-brand:hover { background-color: var(--brand-700); border-color: var(--brand-700); }
        .section-header {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-700) 100%);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
            margin: 0;
            font-weight: 600;
        }
        .form-section {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        .form-section-body {
            padding: 1.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-brand text-white text-center py-4">
                        <h2 class="mb-0">Formulir Pendaftaran Murid Baru</h2>
                        <p class="mb-0 mt-2">TK Islam Annur</p>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('murid.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- SECTION 1: DATA AKUN / LOGIN -->
                            <div class="form-section">
                                <h5 class="section-header">1. Data Akun / Login</h5>
                                <div class="form-section-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: DATA ANAK -->
                            <div class="form-section">
                                <h5 class="section-header">2. Data Anak</h5>
                                <div class="form-section-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="no_induk_sekolah" class="form-label">No. Induk Sekolah</label>
                                            <input type="text" class="form-control" id="no_induk_sekolah" name="no_induk_sekolah" value="{{ old('no_induk_sekolah') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nisn" class="form-label">NISN</label>
                                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}" maxlength="20">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nik_anak" class="form-label">NIK Anak</label>
                                            <input type="text" class="form-control" id="nik_anak" name="nik_anak" value="{{ old('nik_anak') }}" maxlength="20">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="no_akte" class="form-label">No. Akte Kelahiran</label>
                                            <input type="text" class="form-control" id="no_akte" name="no_akte" value="{{ old('no_akte') }}" maxlength="30">
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required maxlength="150">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                            <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="{{ old('nama_panggilan') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih</option>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required maxlength="100">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="agama" class="form-label">Agama</label>
                                            <input type="text" class="form-control" id="agama" name="agama" value="{{ old('agama') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                            <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan') }}" maxlength="50">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobi" class="form-label">Hobi</label>
                                            <input type="text" class="form-control" id="hobi" name="hobi" value="{{ old('hobi') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cita_cita" class="form-label">Cita-cita</label>
                                            <input type="text" class="form-control" id="cita_cita" name="cita_cita" value="{{ old('cita_cita') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="anak_ke" class="form-label">Anak Ke-</label>
                                            <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" min="1">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                                            <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" min="0">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                            <input type="text" class="form-control" id="golongan_darah" name="golongan_darah" value="{{ old('golongan_darah') }}" maxlength="5" placeholder="A, B, AB, O">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                            <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                            <input type="number" step="0.1" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="lingkar_kepala" class="form-label">Lingkar Kepala (cm)</label>
                                            <input type="number" step="0.1" class="form-control" id="lingkar_kepala" name="lingkar_kepala" value="{{ old('lingkar_kepala') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="imunisasi" class="form-label">Imunisasi</label>
                                            <input type="text" class="form-control" id="imunisasi" name="imunisasi" value="{{ old('imunisasi') }}" maxlength="255" placeholder="Contoh: BCG, DPT, Polio, dll">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: DATA ALAMAT -->
                            <div class="form-section">
                                <h5 class="section-header">3. Data Alamat</h5>
                                <div class="form-section-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                                            <textarea class="form-control" id="alamat_jalan" name="alamat_jalan" rows="2" maxlength="255">{{ old('alamat_jalan') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="alamat_kelurahan" class="form-label">Kelurahan</label>
                                            <input type="text" class="form-control" id="alamat_kelurahan" name="alamat_kelurahan" value="{{ old('alamat_kelurahan') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="alamat_kecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="alamat_kecamatan" name="alamat_kecamatan" value="{{ old('alamat_kecamatan') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="alamat_kota" class="form-label">Kota</label>
                                            <input type="text" class="form-control" id="alamat_kota" name="alamat_kota" value="{{ old('alamat_kota') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="alamat_provinsi" class="form-label">Provinsi</label>
                                            <input type="text" class="form-control" id="alamat_provinsi" name="alamat_provinsi" value="{{ old('alamat_provinsi') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kode_pos" class="form-label">Kode Pos</label>
                                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" maxlength="10">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="jarak_sekolah" class="form-label">Jarak ke Sekolah</label>
                                            <input type="text" class="form-control" id="jarak_sekolah" name="jarak_sekolah" value="{{ old('jarak_sekolah') }}" maxlength="50" placeholder="Contoh: 2 km">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 4: DATA ORANG TUA - AYAH -->
                            <div class="form-section">
                                <h5 class="section-header">4. Data Ayah</h5>
                                <div class="form-section-body">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" maxlength="150">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="nik_ayah" class="form-label">NIK Ayah</label>
                                            <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" maxlength="20">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                                            <input type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                                            <input type="date" class="form-control" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                                            <input type="text" class="form-control" id="pendidikan_ayah" name="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}" maxlength="50" placeholder="Contoh: S1, S2, SMA, dll">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                            <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="telp_ayah" class="form-label">No. Telepon Ayah</label>
                                            <input type="text" class="form-control" id="telp_ayah" name="telp_ayah" value="{{ old('telp_ayah') }}" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 5: DATA ORANG TUA - IBU -->
                            <div class="form-section">
                                <h5 class="section-header">5. Data Ibu</h5>
                                <div class="form-section-body">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" maxlength="150">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="nik_ibu" class="form-label">NIK Ibu</label>
                                            <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" maxlength="20">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                                            <input type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                                            <input type="date" class="form-control" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                                            <input type="text" class="form-control" id="pendidikan_ibu" name="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}" maxlength="50" placeholder="Contoh: S1, S2, SMA, dll">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                            <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" maxlength="100">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="telp_ibu" class="form-label">No. Telepon Ibu</label>
                                            <input type="text" class="form-control" id="telp_ibu" name="telp_ibu" value="{{ old('telp_ibu') }}" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 6: BUKTI PEMBAYARAN -->
                            <div class="form-section">
                                <h5 class="section-header">6. Bukti Pembayaran</h5>
                                <div class="form-section-body">
                                    <div class="alert alert-info">
                                        <strong>Penting:</strong> Upload bukti pembayaran pendaftaran. File yang diizinkan: JPG, JPEG, PNG, PDF (maks. 2MB)
                                    </div>
                                    <div class="mb-3">
                                        <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>
                                        <small class="form-text text-muted">Format: JPG, JPEG, PNG, PDF | Maksimal: 2MB</small>
                                    </div>
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('home') }}" class="btn btn-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-brand">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

