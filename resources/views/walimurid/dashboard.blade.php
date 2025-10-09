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
                    {{ $user->name ?? 'Wali Murid' }}
                </h2>

                <!-- Email -->
                <p class="text-xl text-white/90 animate-fade-in" style="animation-delay: 0.4s;">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $user->email ?? '-' }}
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

                            <!-- Info Alert -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-blue-900">Informasi:</p>
                                        <p class="text-blue-800 text-sm mt-1">Belum ada data siswa terhubung. Tambahkan relasi siswa di model User jika diperlukan.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Features List -->
                            <div class="pt-4">
                                <p class="text-gray-700 font-medium mb-4">Setelah data siswa ditambahkan, Anda akan dapat melihat:</p>
                                <ul class="space-y-3">
                                    <li class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        <span>Informasi profil siswa lengkap</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        <span>Jadwal kegiatan harian</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        <span>Laporan perkembangan belajar</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        <span>Riwayat kehadiran</span>
                                    </li>
                                </ul>
                            </div>
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

                    <!-- Menu Item 1 -->
                    <a href="#" class="block bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <h6 class="font-bold text-gray-900">Daftar Kegiatan</h6>
                                <p class="text-sm text-gray-500">Lihat semua aktivitas</p>
                            </div>
                        </div>
                    </a>

                    <!-- Menu Item 2 -->
                    <a href="#" class="block bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h6 class="font-bold text-gray-900">Kontak Sekolah</h6>
                                <p class="text-sm text-gray-500">Hubungi kami</p>
                            </div>
                        </div>
                    </a>
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
