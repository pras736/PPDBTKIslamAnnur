# 📋 Panduan Setup Google OAuth dengan Laravel Socialite

## ✅ Yang Sudah Dikerjakan

1. ✅ **Controller `AuthController`** - Sudah dibuat dengan method `redirectToGoogle()` dan `handleGoogleCallback()`
2. ✅ **Config `config/services.php`** - Sudah ditambahkan konfigurasi Google OAuth
3. ✅ **Routes** - Sudah ditambahkan route `/auth/google` dan `/auth/google/callback`
4. ✅ **View Login** - Sudah ditambahkan tombol "Login dengan Google"

## 🔧 Langkah-langkah Setup

### 1. Install Package Laravel Socialite

Jalankan perintah berikut di terminal:

```bash
composer require laravel/socialite
```

**Catatan:** Jika ada error security advisory, coba dengan:
```bash
composer require laravel/socialite --no-audit
```

### 2. Setup Google Cloud Console

1. **Buka Google Cloud Console**
   - Akses: https://console.cloud.google.com/
   - Pastikan sudah memiliki Project (atau buat Project baru)

2. **Enable Google+ API**
   - Di sidebar, pilih **APIs & Services** → **Library**
   - Cari "Google+ API" atau "Google Identity" 
   - Klik **Enable**

3. **Buat OAuth 2.0 Client ID**
   - Pilih **APIs & Services** → **Credentials**
   - Klik **Create Credentials** → **OAuth Client ID**
   - Pilih **Web Application**
   - Isi form:
     - **Name**: Nama aplikasi (contoh: "TK Islam Annur")
     - **Authorized JavaScript origins** (field pertama):
       - Untuk development: `http://127.0.0.1:8000`
       - Untuk production: `https://domain-kamu.com`
       - ⚠️ **PENTING**: Hanya isi origin (domain + port), TANPA path!
     - **Authorized redirect URIs** (field kedua):
       - Untuk development: `http://127.0.0.1:8000/auth/google/callback`
       - Untuk production: `https://domain-kamu.com/auth/google/callback`
       - ✅ **PENTING**: Isi dengan full path termasuk `/auth/google/callback`
   - Klik **Create**
   - **Copy `Client ID` dan `Client Secret`** (akan digunakan di `.env`)

### 3. Setup File `.env`

Tambahkan konfigurasi berikut di file `.env`:

```env
GOOGLE_CLIENT_ID=xxxxxxxxxxxx-runcntjqat1j56ghqlip78eejl4pdakm.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=xxxxxx-sl9vkVFFmovXgAOp2ZSektxxxxxx
GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/auth/google/callback
```

**Catatan:**
- Ganti `GOOGLE_CLIENT_ID` dengan Client ID dari Google Cloud Console
- Ganti `GOOGLE_CLIENT_SECRET` dengan Client Secret dari Google Cloud Console
- Untuk production, ubah `GOOGLE_REDIRECT_URL` sesuai domain kamu

### 4. Clear Config Cache (Jika Perlu)

Jalankan perintah berikut untuk memastikan config terbaru digunakan:

```bash
php artisan config:clear
php artisan config:cache
```

## 🎯 Cara Kerja

1. **User klik "Login dengan Google"** di halaman login
2. **Redirect ke Google** untuk autentikasi
3. **User setuju** memberikan akses ke aplikasi
4. **Google redirect kembali** ke `/auth/google/callback`
5. **Sistem cek email:**
   - Jika email **sudah terdaftar** → Langsung login
   - Jika email **belum terdaftar** → Buat akun baru dengan role `wali` → Login otomatis
6. **Redirect ke dashboard** sesuai role user

## 🔒 Keamanan

- Email dari Google digunakan sebagai `username` di database
- Password di-generate random (user tidak perlu tahu karena login via Google)
- Role default untuk registrasi via Google adalah `wali` (wali murid)

## ⚠️ Troubleshooting

### Error: "redirect_uri_mismatch"
- Pastikan `GOOGLE_REDIRECT_URL` di `.env` sama persis dengan yang didaftarkan di **Authorized redirect URIs** (bukan JavaScript origins)
- Pastikan tidak ada trailing slash (`/`) yang tidak perlu

### Error: "Invalid Origin: URIs must not contain a path"
- Ini terjadi jika kamu salah mengisi **Authorized JavaScript origins** dengan path
- **Authorized JavaScript origins** hanya butuh origin: `http://127.0.0.1:8000` (tanpa path)
- **Authorized redirect URIs** butuh full path: `http://127.0.0.1:8000/auth/google/callback`

### Error: "Invalid credentials"
- Pastikan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah benar
- Pastikan Google+ API sudah di-enable di Google Cloud Console

### Error: "Class 'Laravel\Socialite\Facades\Socialite' not found"
- Pastikan package sudah terinstall: `composer require laravel/socialite`
- Jalankan: `composer dump-autoload`

## 📝 Catatan

- Untuk production, pastikan menggunakan HTTPS
- Update `GOOGLE_REDIRECT_URL` di `.env` sesuai domain production
- Tambahkan domain production ke **Authorized redirect URIs** di Google Cloud Console

