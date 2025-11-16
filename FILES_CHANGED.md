# Daftar File yang Diubah/Dibuat dalam Refactor

## ✅ File yang Sudah Dibuat/Diubah

### 1. Migration (BARU)
- `database/migrations/2025_11_16_091752_update_akuns_table_change_role_murid_to_wali.php`
- `database/migrations/2025_11_16_091812_add_id_akun_to_gurus_table.php`

### 2. Controller (BARU/DIUBAH)
- ✅ `app/Http/Controllers/RegisterController.php` - **BARU** - Registrasi akun wali murid
- ✅ `app/Http/Controllers/WalimuridController.php` - **DIUBAH** - Role 'wali', validasi semua field wajib
- ✅ `app/Http/Controllers/AdminController.php` - **DIUBAH** - Tambah fitur manajemen akun guru

### 3. Middleware (BARU)
- ✅ `app/Http/Middleware/CheckRole.php` - **BARU**

### 4. Model (DIUBAH)
- ✅ `app/Models/Guru.php` - **DIUBAH** - Tambah relasi ke Akun, tambah id_akun
- ✅ `app/Models/Akun.php` - **DIUBAH** - Tambah relasi ke Guru

### 5. Routes (DIUBAH)
- ✅ `routes/web.php` - **DIUBAH** - Restrukturisasi dengan middleware role

### 6. Views (BARU/DIUBAH)
- ✅ `resources/views/auth/register.blade.php` - **BARU**
- ✅ `resources/views/home.blade.php` - **DIUBAH** - Update role 'wali', update route registrasi

### 7. Bootstrap (DIUBAH)
- ✅ `bootstrap/app.php` - **DIUBAH** - Daftarkan middleware

### 8. Seeder (BARU)
- ✅ `database/seeders/AdminSeeder.php` - **BARU**

## ⚠️ File yang Masih Perlu Diupdate

### 1. Views Dashboard
- ⚠️ `resources/views/walimurid/dashboard.blade.php` - Perlu update menu sesuai requirement
- ⚠️ `resources/views/guru/dashboard.blade.php` - Perlu update tampilan sesuai requirement
- ⚠️ `resources/views/admin/dashboard.blade.php` - Perlu update menu sesuai requirement

### 2. Views Form
- ⚠️ `resources/views/walimurid/create.blade.php` - Perlu update semua field menjadi required
- ⚠️ `resources/views/admin/guru/create.blade.php` - Perlu tambah form username & password

### 3. Controller
- ⚠️ `app/Http/Controllers/GuruController.php` - Perlu update untuk relasi akun

## Langkah Selanjutnya

1. **Jalankan Migration:**
   ```bash
   php artisan migrate
   ```

2. **Jalankan Seeder Admin:**
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

3. **Update Views Dashboard** sesuai requirement di file-file yang disebutkan di atas

4. **Update Form Views** untuk membuat semua field required

5. **Test semua fitur** untuk memastikan tidak ada error

