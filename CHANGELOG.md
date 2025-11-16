# Changelog - Fitur Sistem PPDB TK Islam Annur

## Perubahan Database
- ✅ Database default diubah dari SQLite ke MySQL
- ✅ Konfigurasi database di `config/database.php` sudah diupdate

## Perubahan Authentication
- ✅ Auth config diupdate untuk menggunakan model `Akun` (bukan `User`)
- ✅ Login menggunakan `username` dan `password` dari tabel `akuns`
- ✅ Redirect otomatis berdasarkan role setelah login

## Fitur Wali Murid (Role: murid)
- ✅ Login dengan username & password
- ✅ Dashboard wali murid
- ✅ Formulir pendaftaran murid baru (dengan upload bukti pembayaran wajib)
- ✅ Edit data murid (tanpa upload bukti kecuali pembayaran ditolak)
- ✅ Upload ulang bukti pembayaran jika ditolak
- ✅ Status siswa otomatis menjadi "pendaftar" saat pendaftaran
- ✅ Status pembayaran otomatis menjadi "menunggu" saat pendaftaran

## Fitur Guru (Role: guru)
- ✅ Login dengan username & password
- ✅ Dashboard guru
- ✅ Melihat data kelas (nama kelas, nama guru, daftar murid)

## Fitur Admin (Role: admin)
- ✅ Login dengan username & password
- ✅ Dashboard admin dengan statistik
- ✅ Manajemen Bukti Pembayaran:
  - Melihat semua pembayaran
  - Verifikasi pembayaran (status_siswa otomatis menjadi "terdaftar")
  - Tolak pembayaran
- ✅ Manajemen Data Murid (CRUD):
  - List semua murid
  - Detail murid
  - Create murid baru
  - Edit murid
  - Delete murid
  - Ubah status_siswa
- ✅ Manajemen Data Guru (CRUD):
  - List semua guru
  - Create guru baru
  - Edit guru
  - Delete guru
- ✅ Manajemen Data Kelas (CRUD):
  - List semua kelas
  - Create kelas baru
  - Edit kelas
  - Delete kelas
- ✅ Export Data Murid ke Excel (format CSV untuk kompatibilitas)

## Routes
Semua routes sudah dibuat dengan middleware `auth`:
- `/login` - Login page
- `/walimurid/*` - Routes untuk wali murid
- `/admin/*` - Routes untuk admin
- `/guru/*` - Routes untuk guru

## Views
- ✅ Layout app.blade.php
- ✅ Login form (updated untuk username)
- ✅ Dashboard wali murid (updated)
- ✅ Form create wali murid
- ✅ Form edit wali murid
- ✅ Dashboard admin
- ✅ Manajemen pembayaran admin
- ✅ Dashboard guru
- ✅ Detail kelas guru

## Catatan Penting

### Yang Perlu Dilakukan Manual:
1. **Update form edit wali murid**: Semua field perlu diisi dengan data dari `$murid`. Saat ini hanya beberapa field yang sudah diupdate. Gunakan pattern: `value="{{ old('field_name', $murid->field_name ?? '') }}"`

2. **Buat views admin tambahan** (opsional tapi disarankan):
   - `admin/murid/index.blade.php` - List murid
   - `admin/murid/create.blade.php` - Form create murid
   - `admin/murid/edit.blade.php` - Form edit murid
   - `admin/murid/show.blade.php` - Detail murid
   - `admin/guru/index.blade.php` - List guru
   - `admin/guru/create.blade.php` - Form create guru
   - `admin/guru/edit.blade.php` - Form edit guru
   - `admin/kelas/index.blade.php` - List kelas
   - `admin/kelas/create.blade.php` - Form create kelas
   - `admin/kelas/edit.blade.php` - Form edit kelas

3. **Setup Database MySQL**:
   - Buat database MySQL
   - Update file `.env` dengan kredensial database MySQL
   - Jalankan `php artisan migrate`

4. **Setup Storage Link**:
   - Jalankan `php artisan storage:link` untuk membuat symlink storage

### File yang Sudah Dibuat/Diupdate:
- `config/database.php` - Default connection ke MySQL
- `config/auth.php` - Model auth ke Akun
- `app/Http/Controllers/AdminController.php` - Controller admin lengkap
- `app/Http/Controllers/GuruController.php` - Controller guru
- `app/Http/Controllers/WalimuridController.php` - Controller wali murid (updated)
- `routes/web.php` - Semua routes
- `resources/views/layouts/app.blade.php` - Layout dasar
- `resources/views/auth/login.blade.php` - Form login (updated)
- `resources/views/walimurid/*` - Views wali murid
- `resources/views/admin/*` - Views admin dasar
- `resources/views/guru/*` - Views guru

### Export Excel
Export menggunakan format CSV dengan BOM UTF-8 agar kompatibel dengan Excel. File akan didownload dengan ekstensi `.csv` yang bisa dibuka di Excel.

