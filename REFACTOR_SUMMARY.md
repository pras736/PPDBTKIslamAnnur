# Ringkasan Refactor Sistem PPDB TK Islam Annur

## File yang Diubah/Dibuat

### 1. Migration
- ✅ `database/migrations/2025_11_16_091752_update_akuns_table_change_role_murid_to_wali.php` - Update role dari 'murid' ke 'wali'
- ✅ `database/migrations/2025_11_16_091812_add_id_akun_to_gurus_table.php` - Tambah id_akun ke tabel gurus

### 2. Controller
- ✅ `app/Http/Controllers/RegisterController.php` - **BARU** - Controller untuk registrasi akun wali murid (public)
- ✅ `app/Http/Controllers/WalimuridController.php` - **DIUBAH** - Update role dari 'murid' ke 'wali', validasi semua field wajib
- ✅ `app/Http/Controllers/AdminController.php` - **DIUBAH** - Tambah fitur manajemen akun guru (create dengan akun, reset password)

### 3. Middleware
- ✅ `app/Http/Middleware/CheckRole.php` - **BARU** - Middleware untuk cek role user

### 4. Model
- ✅ `app/Models/Guru.php` - **DIUBAH** - Tambah relasi ke Akun, tambah id_akun di fillable
- ✅ `app/Models/Akun.php` - **DIUBAH** - Tambah relasi ke Guru

### 5. Routes
- ✅ `routes/web.php` - **DIUBAH** - Restrukturisasi routes dengan middleware role, tambah route registrasi

### 6. Views
- ✅ `resources/views/auth/register.blade.php` - **BARU** - Form registrasi akun wali murid
- ✅ `resources/views/home.blade.php` - **DIUBAH** - Redirect jika sudah login, update menu

### 7. Bootstrap
- ✅ `bootstrap/app.php` - **DIUBAH** - Daftarkan middleware CheckRole

### 8. Seeder
- ✅ `database/seeders/AdminSeeder.php` - **BARU** - Seeder untuk akun admin default

## Perubahan Utama

### A. Struktur Form Registrasi (DIPISAH)

1. **Form Registrasi Akun Wali Murid** (Public)
   - Route: `/register` (GET & POST)
   - Controller: `RegisterController`
   - View: `resources/views/auth/register.blade.php`
   - Setelah sukses → redirect ke login
   - Role: `wali` (bukan `murid`)

2. **Form Pendaftaran Peserta Didik** (Hanya setelah login wali)
   - Route: `/walimurid/create` (GET & POST)
   - Controller: `WalimuridController`
   - View: `resources/views/walimurid/create.blade.php`
   - **Semua field wajib diisi**
   - Upload bukti pembayaran wajib

### B. Login & Dashboard

- Login redirect otomatis ke dashboard sesuai role:
  - `admin` → `/admin/dashboard`
  - `guru` → `/guru/dashboard`
  - `wali` → `/walimurid/dashboard`

### C. Home Page

- Jika belum login: tampilkan welcome + tombol login + tombol registrasi
- Jika sudah login: redirect otomatis ke dashboard sesuai role

### D. Manajemen Akun Guru

Admin bisa:
- Buat akun guru (otomatis buat di tabel `akuns` dan `gurus`)
- Edit akun guru
- Reset password guru (default: `guru123`)
- Delete guru (otomatis delete akun juga)

### E. Routing dengan Middleware

- Routes dipisah berdasarkan role dengan middleware `role:admin`, `role:guru`, `role:wali`
- Middleware `CheckRole` sudah didaftarkan di `bootstrap/app.php`

## Yang Perlu Dilakukan

1. **Jalankan Migration:**
   ```bash
   php artisan migrate
   ```

2. **Jalankan Seeder Admin:**
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

3. **Update Views Dashboard:**
   - `resources/views/walimurid/dashboard.blade.php` - Update menu sesuai requirement
   - `resources/views/guru/dashboard.blade.php` - Update tampilan sesuai requirement
   - `resources/views/admin/dashboard.blade.php` - Update menu sesuai requirement

4. **Update Form Views:**
   - `resources/views/walimurid/create.blade.php` - Update semua field menjadi required
   - `resources/views/admin/guru/create.blade.php` - Tambah form username & password

5. **Update Model Guru:**
   - Pastikan migration sudah dijalankan untuk menambahkan kolom `id_akun`

## Catatan Penting

- Role sekarang: `admin`, `guru`, `wali` (bukan `murid`)
- Semua field form pendaftaran murid **WAJIB** diisi
- Form registrasi akun wali murid adalah **PUBLIC** (tidak perlu login)
- Form pendaftaran murid hanya bisa diakses setelah **login sebagai wali**
- Admin bisa membuat akun guru yang otomatis terhubung ke tabel `gurus`

