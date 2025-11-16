<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TK Islam Annur</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

    <style>
      /* Brand color override: emerald + amber, 4-color palette total */
      :root{
        --brand: #16a34a;   /* emerald-600 */
        --brand-700: #15803d;
        --accent: #f59e0b;  /* amber-500 */
        --muted: #6b7280;   /* gray-500 */
      }
      .bg-brand{ background-color: var(--brand) !important; }
      .text-brand{ color: var(--brand) !important; }
      .btn-brand{
        background-color: var(--brand); border-color: var(--brand);
        color: #fff;
      }
      .btn-brand:hover{ background-color: var(--brand-700); border-color: var(--brand-700); }
      .badge-accent{ background-color: var(--accent); }
      .nav-link.active{ color: var(--brand) !important; font-weight: 600; }
      .hero{
        background: linear-gradient(180deg, rgba(22,163,74,0.08), rgba(22,163,74,0.02));
      }
      .logo-rounded{
        border-radius: 0.5rem; border: 2px solid #e5e7eb; background:#fff;
      }
      .shadow-soft{ box-shadow: 0 10px 24px rgba(16,24,40,0.06); }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/" aria-label="TK Islam Annur">
          <img src="{{ asset('images/logo-tk-annur.jpg') }}" width="36" height="36" alt="Logo TK Islam Annur" class="logo-rounded" />
          <span class="fw-bold text-brand">TK Islam Annur</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Buka navigasi">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
            @auth
              {{-- Menu untuk user yang sudah login --}}
              @if(Auth::user()->role == 'admin')
                {{-- Menu Admin --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.murid.index') }}">Manajemen Murid</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.guru.index') }}">Manajemen Guru</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.kelas.index') }}">Manajemen Kelas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.pembayaran.index') }}">Bukti Pembayaran</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.export.murid') }}">Export Excel</a></li>
                <li class="nav-item ms-lg-3">
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                  </form>
                </li>
              @elseif(Auth::user()->role == 'guru')
                {{-- Menu Guru --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('guru.dashboard') }}">Data Kelas</a></li>
                <li class="nav-item ms-lg-3">
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                  </form>
                </li>
              @elseif(Auth::user()->role == 'wali')
                {{-- Menu Wali Murid --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('walimurid.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('walimurid.create') }}">Formulir Pendaftaran</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('walimurid.edit') }}">Edit Data Anak</a></li>
                <li class="nav-item ms-lg-3">
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                  </form>
                </li>
              @endif
            @else
              {{-- Menu untuk pengunjung yang belum login --}}
              <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
              <li class="nav-item"><a class="nav-link" href="#program">Program</a></li>
              <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
              <li class="nav-item ms-lg-3">
                <a class="btn btn-brand btn-sm px-3" href="{{ route('login') }}">Login</a>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    {{-- Konten Utama --}}
    @auth
      {{-- ============================================ --}}
      {{-- HALAMAN UNTUK USER YANG SUDAH LOGIN --}}
      {{-- ============================================ --}}
      
      @if(Auth::user()->role == 'admin')
        {{-- Dashboard Admin --}}
        <main class="py-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="card shadow-soft">
                  <div class="card-header bg-brand text-white">
                    <h2 class="h4 mb-0">Dashboard Admin - TK Islam Annur</h2>
                  </div>
                  <div class="card-body">
                    <p class="lead">Selamat datang, <strong>{{ Auth::user()->username }}</strong>!</p>
                    <p>Anda login sebagai <span class="badge bg-danger">Administrator</span></p>
                    
                    <hr>
                    
                    <h3 class="h5 mb-3">Menu Admin</h3>
                    <div class="row g-3">
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Dashboard</h5>
                            <p class="card-text small text-secondary">Lihat statistik dan ringkasan data</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-brand btn-sm">Buka Dashboard</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Manajemen Murid</h5>
                            <p class="card-text small text-secondary">CRUD data murid</p>
                            <a href="{{ route('admin.murid.index') }}" class="btn btn-brand btn-sm">Kelola Murid</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Manajemen Guru</h5>
                            <p class="card-text small text-secondary">CRUD data guru</p>
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-brand btn-sm">Kelola Guru</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Manajemen Kelas</h5>
                            <p class="card-text small text-secondary">CRUD data kelas</p>
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-brand btn-sm">Kelola Kelas</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Bukti Pembayaran</h5>
                            <p class="card-text small text-secondary">Verifikasi dan tolak pembayaran</p>
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-brand btn-sm">Lihat Pembayaran</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Export Data Murid</h5>
                            <p class="card-text small text-secondary">Export ke Excel untuk Dapodik</p>
                            <a href="{{ route('admin.export.murid') }}" class="btn btn-success btn-sm">Download Excel</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>

      @elseif(Auth::user()->role == 'guru')
        {{-- Dashboard Guru --}}
        <main class="py-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="card shadow-soft">
                  <div class="card-header bg-brand text-white">
                    <h2 class="h4 mb-0">Dashboard Guru - TK Islam Annur</h2>
                  </div>
                  <div class="card-body">
                    <p class="lead">Selamat datang, <strong>{{ Auth::user()->username }}</strong>!</p>
                    <p>Anda login sebagai <span class="badge bg-info">Guru</span></p>
                    
                    <hr>
                    
                    <h3 class="h5 mb-3">Menu Guru</h3>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Dashboard</h5>
                            <p class="card-text small text-secondary">Lihat ringkasan data kelas</p>
                            <a href="{{ route('guru.dashboard') }}" class="btn btn-brand btn-sm">Buka Dashboard</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Data Kelas</h5>
                            <p class="card-text small text-secondary">Lihat nama kelas, nama guru, dan daftar murid</p>
                            <a href="{{ route('guru.dashboard') }}" class="btn btn-brand btn-sm">Lihat Kelas</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>

              @elseif(Auth::user()->role == 'wali')
        {{-- Dashboard Wali Murid --}}
        <main class="py-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="card shadow-soft">
                  <div class="card-header bg-brand text-white">
                    <h2 class="h4 mb-0">Dashboard Wali Murid - TK Islam Annur</h2>
                  </div>
                  <div class="card-body">
                    <p class="lead">Selamat datang, <strong>{{ Auth::user()->username }}</strong>!</p>
                    <p>Anda login sebagai <span class="badge bg-warning">Wali Murid</span></p>
                    
                    <hr>
                    
                    <h3 class="h5 mb-3">Menu Wali Murid</h3>
                    <div class="row g-3">
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Dashboard</h5>
                            <p class="card-text small text-secondary">Lihat informasi data anak Anda</p>
                            <a href="{{ route('walimurid.dashboard') }}" class="btn btn-brand btn-sm">Buka Dashboard</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Formulir Pendaftaran</h5>
                            <p class="card-text small text-secondary">Isi formulir pendaftaran murid baru</p>
                            <a href="{{ route('walimurid.create') }}" class="btn btn-brand btn-sm">Isi Formulir</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Edit Data Anak</h5>
                            <p class="card-text small text-secondary">Update data anak Anda</p>
                            <a href="{{ route('walimurid.edit') }}" class="btn btn-brand btn-sm">Edit Data</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">Upload Bukti Pembayaran</h5>
                            <p class="card-text small text-secondary">Upload atau upload ulang bukti pembayaran</p>
                            <a href="{{ route('walimurid.edit') }}" class="btn btn-brand btn-sm">Upload Bukti</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      @endif

    @else
      {{-- ============================================ --}}
      {{-- HALAMAN UNTUK PENGUNJUNG BELUM LOGIN --}}
      {{-- ============================================ --}}
      
      <header id="beranda" class="hero py-5 py-lg-6">
        <div class="container">
          <div class="row align-items-center gy-4">
            <div class="col-lg-7">
              <span class="badge badge-accent text-dark mb-3">Yayasan Annur</span>
              <h1 class="display-5 fw-bold text-balance">Selamat Datang di TK Islam Annur</h1>
              <p class="lead text-secondary mt-3">
                Tumbuhkan akhlak, kemandirian, dan kreativitas anak dalam lingkungan islami yang hangat dan menyenangkan.
              </p>
              <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('login') }}" class="btn btn-brand btn-lg">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrasi Akun Wali Murid</a>
                <a href="#tentang" class="btn btn-outline-secondary btn-lg">Pelajari Lebih Lanjut</a>
              </div>
            </div>
            <div class="col-lg-5 text-center">
              <img src="{{ asset('images/logo-tk-annur.jpg') }}" class="img-fluid p-3 logo-rounded shadow-soft" alt="Lambang TK Islam Annur" width="360" height="360" />
            </div>
          </div>
        </div>
      </header>

      <main class="py-5">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-8">
              <section id="tentang" class="card border-0 shadow-soft mb-4">
                <div class="card-body">
                  <h2 class="h4 mb-3">Tentang Sekolah</h2>
                  <p class="text-secondary mb-0">
                    TK Islam Annur berkomitmen memberikan pendidikan karakter dan dasar-dasar literasi-numerasi melalui pendekatan bermain yang terarah, sesuai nilai-nilai Islam.
                  </p>
                </div>
              </section>

              <section class="card border-0 shadow-soft mb-4">
                <div class="card-body">
                  <h3 class="h5 mb-3">Visi & Misi</h3>
                  <div class="accordion" id="visimisi">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="visi-heading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#visi" aria-expanded="true" aria-controls="visi">
                          Visi
                        </button>
                      </h2>
                      <div id="visi" class="accordion-collapse collapse show" aria-labelledby="visi-heading" data-bs-parent="#visimisi">
                        <div class="accordion-body">
                          Menjadi lembaga pendidikan anak usia dini yang unggul dalam membentuk generasi berakhlak mulia, cerdas, dan mandiri.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="misi-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#misi" aria-expanded="false" aria-controls="misi">
                          Misi
                        </button>
                      </h2>
                      <div id="misi" class="accordion-collapse collapse" aria-labelledby="misi-heading" data-bs-parent="#visimisi">
                        <div class="accordion-body">
                          <ul class="mb-0">
                            <li>Menanamkan nilai-nilai Islam sejak dini melalui pembiasaan.</li>
                            <li>Mendorong kreativitas melalui kegiatan bermain dan bereksplorasi.</li>
                            <li>Membangun kemandirian dan kerja sama dalam lingkungan yang menyenangkan.</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section id="program" class="card border-0 shadow-soft">
                <div class="card-body">
                  <h3 class="h5 mb-3">Program Unggulan</h3>
                  <div class="mb-3 d-flex flex-wrap gap-2">
                    <span class="badge bg-success-subtle text-success border">Tahfiz Harian</span>
                    <span class="badge bg-success-subtle text-success border">Adab & Doa</span>
                    <span class="badge bg-success-subtle text-success border">Sains Mini</span>
                    <span class="badge bg-success-subtle text-success border">Kreativitas Seni</span>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h4 class="h6">Kurikulum</h4>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">PAUD berbasis karakter</li>
                            <li class="list-group-item">Pembiasaan salat & wudu</li>
                            <li class="list-group-item">Literasi & numerasi bermain</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h4 class="h6">Fasilitas</h4>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">Kelas nyaman & aman</li>
                            <li class="list-group-item">Area bermain edukatif</li>
                            <li class="list-group-item">Peralatan belajar lengkap</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>

            <div class="col-lg-4">
              <section class="card border-0 shadow-soft mb-4" id="ppdb">
                <div class="card-body">
                  <h3 class="h5 mb-3">Pengumuman / PPDB</h3>
                  <div class="alert alert-success" role="alert">
                    Pendaftaran Tahun Ajaran Baru telah dibuka. Klik tombol di bawah untuk mendaftar.
                  </div>
                  <div class="d-grid gap-2">
                    <a class="btn btn-brand" href="{{ route('register') }}">Daftar Sekarang</a>
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                  </div>
                </div>
              </section>

              <section class="card border-0 shadow-soft mb-4">
                <div class="card-body">
                  <h4 class="h6 mb-3">Aksi Cepat</h4>
                  <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-brand btn-sm" href="#tentang">Profil</a>
                    <a class="btn btn-outline-secondary btn-sm" href="#program">Kegiatan</a>
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-outline-success btn-sm" href="{{ route('register') }}">Daftar</a>
                  </div>
                </div>
              </section>

              <section class="card border-0 shadow-soft">
                <div class="card-body">
                  <h4 class="h6 mb-3">Jadwal Kegiatan</h4>
                  <div class="table-responsive">
                    <table class="table table-sm align-middle">
                      <thead class="table-light">
                        <tr>
                          <th>Hari</th>
                          <th>Kegiatan</th>
                          <th>Waktu</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><td>Senin</td><td>Upacara & Tahfiz</td><td>07.30–09.30</td></tr>
                        <tr><td>Rabu</td><td>Sains Mini</td><td>08.00–09.00</td></tr>
                        <tr><td>Jumat</td><td>Adab & Doa</td><td>08.00–09.30</td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>

          <section id="guru" class="mt-5">
            <h2 class="h4 mb-3">Guru Kami</h2>
            <div class="row g-3">
              <div class="col-sm-6 col-lg-3">
                <div class="card h-100 shadow-soft">
                  <div class="card-body text-center">
                    <img src="/placeholder.svg?height=120&width=120" alt="Foto Guru" class="rounded-circle mb-2" width="120" height="120" />
                    <div class="fw-semibold">Bu Aisyah</div>
                    <div class="small text-secondary">Wali Kelas A</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card h-100 shadow-soft">
                  <div class="card-body text-center">
                    <img src="/placeholder.svg?height=120&width=120" alt="Foto Guru" class="rounded-circle mb-2" width="120" height="120" />
                    <div class="fw-semibold">Bu Fatimah</div>
                    <div class="small text-secondary">Wali Kelas B</div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section id="kontak" class="mt-5">
            <h2 class="h4 mb-3">Kontak</h2>
            <div class="row g-4">
              <div class="col-lg-6">
                <div class="card border-0 shadow-soft">
                  <div class="card-body">
                    <form>
                      <div class="mb-3">
                        <label class="form-label" for="nama">Nama</label>
                        <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama Anda" />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="email@contoh.com" />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="pesan">Pesan</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Tulis pesan Anda"></textarea>
                      </div>
                      <button type="submit" class="btn btn-brand">Kirim</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card border-0 shadow-soft h-100">
                  <div class="card-body">
                    <div class="mb-2 fw-semibold">Alamat</div>
                    <div class="text-secondary mb-3">Jl. Contoh No. 123, Pekanbaru</div>
                    <div class="mb-2 fw-semibold">Telepon</div>
                    <div class="text-secondary mb-3">0812-3456-7890</div>
                    <div class="mb-2 fw-semibold">Email</div>
                    <div class="text-secondary">info@tkislamannur.sch.id</div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
    @endauth

    <footer class="border-top py-4 mt-5">
      <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/logo-tk-annur.jpg') }}" width="28" height="28" alt="Logo kecil TK Islam Annur" class="logo-rounded" />
          <span class="small text-secondary">&copy; {{ date('Y') }} TK Islam Annur. Semua hak dilindungi.</span>
        </div>
        <div class="small">
          <a class="link-secondary text-decoration-none me-3" href="#tentang">Tentang</a>
          <a class="link-secondary text-decoration-none" href="#kontak">Kontak</a>
        </div>
      </div>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
