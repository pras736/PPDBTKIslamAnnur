<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Wali Murid - TK Islam Annur</title>
    @php
        $viteManifest = public_path('build/manifest.json');
    @endphp

    @if (file_exists($viteManifest))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Vite manifest not found — fallback to CDN so page still renders in dev without building assets --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* Minimal fallback styles to keep spacing similar */
            body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
        </style>
    @endif
</head>
<body class="font-sans antialiased">
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
                    <div class="hidden lg:flex items-center gap-8">
                        <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                            Home
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                            Kegiatan
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                            Jadwal
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-colors relative group">
                            Kontak
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </div>

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

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 min-h-[40vh] flex items-center overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-yellow-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white space-y-3 py-8">
                <!-- Badge -->
                <div class="inline-block px-6 py-2.5 bg-yellow-400/20 border border-yellow-400/30 rounded-full text-yellow-400 font-semibold text-sm tracking-wider uppercase animate-bounce">
                    Portal Wali Murid
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-black leading-tight animate-fade-in">
                    Selamat Datang
                </h1>

                <!-- User Name -->
                <h2 class="text-2xl md:text-3xl font-bold animate-fade-in" style="animation-delay: 0.2s;">
                    {{ $user->username ?? 'Wali Murid' }}
                </h2>

                <!-- Status -->
                <p class="text-xl text-white/90 animate-fade-in" style="animation-delay: 0.4s;">
                    @if($murid)
                        Status: <span class="font-bold">{{ ucfirst($murid->status_siswa) }}</span>
                    @else
                        Belum ada data murid
                    @endif
                </p>

                <!-- CTA Button -->
                <div class="pt-3 animate-fade-in" style="animation-delay: 0.6s;">
                    <a href="#content" class="inline-block px-8 py-3 border-2 border-yellow-400 text-yellow-400 rounded-lg font-semibold text-base hover:bg-yellow-400 hover:text-blue-900 hover:-translate-y-1 transition-all duration-300">
                        Lihat Dashboard
                    </a>
                </div>

                <!-- Play Button -->
                <div class="pt-4 animate-fade-in" style="animation-delay: 0.8s;">
                    <button class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mx-auto hover:scale-105 transition-transform duration-300 shadow-2xl shadow-yellow-400/50">
                        <svg class="w-5 h-5 text-blue-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section id="content" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-6 py-2 bg-green-100 text-green-700 rounded-full font-semibold text-sm tracking-wider uppercase mb-4">
                    Dashboard
                </span>
                <h2 class="text-5xl font-black text-gray-900">
                    Informasi Siswa Anda
                </h2>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Main Content Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-8 space-y-6">
                            <!-- Icon -->
                            <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>

                            <!-- Title -->
                            <h5 class="text-2xl font-bold text-gray-900">Data Siswa</h5>

                            @if(session('success'))
                                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                                    <p class="text-green-800">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if(session('info'))
                                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                                    <p class="text-blue-800">{{ session('info') }}</p>
                                </div>
                            @endif

                            @if($murid)
                                <!-- Data Murid -->
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $murid->nama_lengkap }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Siswa</p>
                                        <p class="text-lg font-semibold">
                                            <span class="px-3 py-1 rounded-full {{ $murid->status_siswa === 'terdaftar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($murid->status_siswa) }}
                                            </span>
                                        </p>
                                    </div>
                                    @if($murid->pembayaranTerbaru)
                                        <div>
                                            <p class="text-sm text-gray-500">Status Pembayaran</p>
                                            <p class="text-lg font-semibold">
                                                @if($murid->pembayaranTerbaru->status_pembayaran === 'diverifikasi')
                                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800">Diverifikasi</span>
                                                @elseif($murid->pembayaranTerbaru->status_pembayaran === 'ditolak')
                                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-6">
                                    <a href="{{ route('walimurid.edit') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                        Edit Data Anak
                                    </a>
                                </div>
                            @else
                                <!-- Info Alert -->
                                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-blue-900">Belum ada data siswa</p>
                                            <p class="text-blue-800 text-sm mt-1">Silakan isi formulir pendaftaran untuk mendaftarkan anak Anda.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <a href="{{ route('walimurid.create') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                        Isi Formulir Pendaftaran
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Welcome Box -->
                    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-3xl p-6 text-white shadow-xl">
                        <h4 class="text-2xl font-bold mb-2">Menu Cepat</h4>
                        <p class="text-green-100">Akses fitur-fitur penting dengan mudah</p>
                    </div>

                    @if(!$murid)
                        <!-- Menu Item 1 -->
                        <a href="{{ route('walimurid.create') }}" class="block bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="font-bold text-gray-900">Formulir Pendaftaran</h6>
                                    <p class="text-sm text-gray-500">Daftarkan anak Anda</p>
                                </div>
                            </div>
                        </a>
                    @else
                        <!-- Menu Item 1 -->
                        <a href="{{ route('walimurid.edit') }}" class="block bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="font-bold text-gray-900">Edit Data</h6>
                                    <p class="text-sm text-gray-500">Ubah data anak</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
    </style>
</body>
</html>
