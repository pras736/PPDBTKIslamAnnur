<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Murid Baru - TK Islam Annur</title>
    @php
        $viteManifest = public_path('build/manifest.json');
    @endphp

    @if (file_exists($viteManifest))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Vite manifest not found — fallback to CDN so page still renders in dev without building assets --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
        </style>
    @endif
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <a href="/" class="flex items-center gap-3 hover:-translate-y-0.5 transition-transform duration-300">
                    <img src="{{ asset('images/logo-tk-annur.jpg') }}"
                         alt="Logo"
                         class="w-12 h-12 rounded-xl border-2 border-gray-200 p-1.5 bg-white shadow-md hover:rotate-6 hover:scale-105 transition-all duration-300">
                    <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                        TK Islam Annur
                    </span>
                </a>

                <div class="flex items-center gap-6">
                    <a href="{{ route('walimurid.dashboard') }}" class="px-6 py-2.5 border-2 border-gray-200 rounded-lg font-semibold text-gray-700 hover:bg-green-600 hover:text-white hover:border-green-600 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-6 py-2.5 border-2 border-gray-200 rounded-lg font-semibold text-gray-700 hover:bg-green-600 hover:text-white hover:border-green-600 hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-md border-t-4 border-green-700 overflow-hidden mb-8">
                <div class="p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-700 rounded-full flex items-center justify-center text-white">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Formulir Pendaftaran Murid Baru</h1>
                            <p class="text-gray-600">TK Islam Annur</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-700 to-green-600 px-8 py-4">
                    <div class="text-white text-sm">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-red-900 mb-2">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside text-red-800 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('walimurid.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- SECTION 1: DATA ANAK -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-green-700"></i>
                            1. Data Anak
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="nik_anak" class="block text-sm font-medium text-gray-700 mb-1">NIK Anak <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nik_anak" name="nik_anak" value="{{ old('nik_anak') }}" required maxlength="20">
                            </div>
                            <div>
                                <label for="no_akte" class="block text-sm font-medium text-gray-700 mb-1">No. Akte Kelahiran <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="no_akte" name="no_akte" value="{{ old('no_akte') }}" required maxlength="30">
                            </div>
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required maxlength="150">
                            </div>
                            <div>
                                <label for="nama_panggilan" class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nama_panggilan" name="nama_panggilan" value="{{ old('nama_panggilan') }}" required maxlength="50">
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="agama" name="agama" value="{{ old('agama') }}" required maxlength="50">
                            </div>
                            <div>
                                <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700 mb-1">Kewarganegaraan <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan') }}" required maxlength="50">
                            </div>
                            <div>
                                <label for="hobi" class="block text-sm font-medium text-gray-700 mb-1">Hobi <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="hobi" name="hobi" value="{{ old('hobi') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="cita_cita" class="block text-sm font-medium text-gray-700 mb-1">Cita-cita <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="cita_cita" name="cita_cita" value="{{ old('cita_cita') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="anak_ke" class="block text-sm font-medium text-gray-700 mb-1">Anak Ke- <span class="text-red-500">*</span></label>
                                <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" required min="1">
                            </div>
                            <div>
                                <label for="jumlah_saudara" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Saudara <span class="text-red-500">*</span></label>
                                <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" required min="0">
                            </div>
                            <div>
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="golongan_darah" name="golongan_darah" value="{{ old('golongan_darah') }}" required maxlength="5" placeholder="A, B, AB, O">
                            </div>
                            <div>
                                <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}" required>
                            </div>
                            <div>
                                <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}" required>
                            </div>
                            <div>
                                <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-1">Lingkar Kepala (cm) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="lingkar_kepala" name="lingkar_kepala" value="{{ old('lingkar_kepala') }}" required>
                            </div>
                            <div>
                                <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-1">Imunisasi <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="imunisasi" name="imunisasi" value="{{ old('imunisasi') }}" required maxlength="255" placeholder="Contoh: BCG, DPT, Polio, dll">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: DATA ALAMAT -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="home" class="w-5 h-5 text-green-700"></i>
                            2. Data Alamat
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="alamat_jalan" class="block text-sm font-medium text-gray-700 mb-1">Alamat Jalan <span class="text-red-500">*</span></label>
                                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="alamat_jalan" name="alamat_jalan" rows="2" required maxlength="255">{{ old('alamat_jalan') }}</textarea>
                            </div>
                            <div>
                                <label for="alamat_kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="alamat_kelurahan" name="alamat_kelurahan" value="{{ old('alamat_kelurahan') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="alamat_kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="alamat_kecamatan" name="alamat_kecamatan" value="{{ old('alamat_kecamatan') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="alamat_kota" class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="alamat_kota" name="alamat_kota" value="{{ old('alamat_kota') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="alamat_provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="alamat_provinsi" name="alamat_provinsi" value="{{ old('alamat_provinsi') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" required maxlength="10">
                            </div>
                            <div>
                                <label for="jarak_sekolah" class="block text-sm font-medium text-gray-700 mb-1">Jarak ke Sekolah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="jarak_sekolah" name="jarak_sekolah" value="{{ old('jarak_sekolah') }}" required maxlength="50" placeholder="Contoh: 2 km">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: DATA AYAH -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-green-700"></i>
                            3. Data Ayah
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" required maxlength="150">
                            </div>
                            <div>
                                <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-1">NIK Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" required maxlength="20">
                            </div>
                            <div>
                                <label for="tempat_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tempat_lahir_ayah" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir Ayah <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" required>
                            </div>
                            <div>
                                <label for="pendidikan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="pendidikan_ayah" name="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}" required maxlength="50" placeholder="Contoh: S1, S2, SMA, dll">
                            </div>
                            <div>
                                <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="telp_ayah" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Ayah <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="telp_ayah" name="telp_ayah" value="{{ old('telp_ayah') }}" required maxlength="20">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: DATA IBU -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-green-700"></i>
                            4. Data Ibu
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" required maxlength="150">
                            </div>
                            <div>
                                <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-1">NIK Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" required maxlength="20">
                            </div>
                            <div>
                                <label for="tempat_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tempat_lahir_ibu" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir Ibu <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}" required>
                            </div>
                            <div>
                                <label for="pendidikan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="pendidikan_ibu" name="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}" required maxlength="50" placeholder="Contoh: S1, S2, SMA, dll">
                            </div>
                            <div>
                                <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required maxlength="100">
                            </div>
                            <div>
                                <label for="telp_ibu" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Ibu <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="telp_ibu" name="telp_ibu" value="{{ old('telp_ibu') }}" required maxlength="20">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 5: BUKTI PEMBAYARAN -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i data-lucide="file-check" class="w-5 h-5 text-green-700"></i>
                            5. Bukti Pembayaran (Wajib)
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i data-lucide="info" class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-blue-900 mb-1">Penting:</p>
                                    <p class="text-blue-800 text-sm">Upload bukti pembayaran pendaftaran. File yang diizinkan: JPG, JPEG, PNG, PDF (maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                            <input type="file" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG, PDF | Maksimal: 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT BUTTONS -->
                <div class="flex gap-4">
                    <a href="{{ route('walimurid.dashboard') }}" class="flex-1 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 py-3 px-6 rounded-md font-semibold transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="x" class="w-5 h-5"></i>
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-green-700 hover:bg-green-800 text-white py-3 px-6 rounded-md font-semibold transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
