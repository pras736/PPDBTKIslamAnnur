<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use App\Models\Murid;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class MuridSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Nama-nama Indonesia untuk anak-anak
        $namaDepanLaki = ['Ahmad', 'Muhammad', 'Ali', 'Umar', 'Hasan', 'Husain', 'Ibrahim', 'Yusuf', 'Adam', 'Dzakwan', 'Faris', 'Rafi', 'Rizki', 'Bayu', 'Dafa'];
        $namaDepanPerempuan = ['Aisyah', 'Fatimah', 'Khadijah', 'Zainab', 'Maryam', 'Hafshah', 'Aminah', 'Nisa', 'Salsabila', 'Najwa', 'Kayla', 'Zahra', 'Aulia', 'Naura', 'Putri'];
        $namaBelakang = ['Rahman', 'Rahimi', 'Hidayat', 'Nurhakim', 'Maulana', 'Fauzi', 'Ramadhan', 'Prasetyo', 'Wijaya', 'Santoso'];
        
        // Buat 50 murid dengan data lengkap
        for ($i = 0; $i < 50; $i++) {
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $namaDepan = $jenisKelamin === 'L' 
                ? $faker->randomElement($namaDepanLaki) 
                : $faker->randomElement($namaDepanPerempuan);
            $namaLengkap = $namaDepan . ' ' . $faker->randomElement($namaBelakang);
            
            // Buat akun wali
            $usernameWali = 'wali' . strtolower(str_replace(' ', '', $namaDepan)) . ($i + 1);
            
            $akun = Akun::create([
                'username' => $usernameWali,
                'password' => Hash::make('password'),
                'password_plain' => 'password',
                'role' => 'wali',
            ]);

            // Data tanggal lahir (usia 3-6 tahun untuk TK)
            $tanggalLahir = $faker->dateTimeBetween('-6 years', '-3 years');
            $tanggalLahirAyah = $faker->dateTimeBetween('-45 years', '-25 years');
            $tanggalLahirIbu = $faker->dateTimeBetween('-40 years', '-23 years');

            Murid::create([
                'id_akun' => $akun->id_akun,
                'status_siswa' => $faker->randomElement(['pendaftar', 'terdaftar']),
                'no_induk_sekolah' => 'ND-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nik_anak' => $faker->numerify('################'),
                'no_akte' => $faker->bothify('AKTE-???-####'),
                'nama_lengkap' => $namaLengkap,
                'nama_panggilan' => $namaDepan,
                'jenis_kelamin' => $jenisKelamin === 'L' ? 'L' : 'P',
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'agama' => 'Islam',
                'kewarganegaraan' => 'Indonesia',
                'hobi' => $faker->randomElement(['Menggambar', 'Menyanyi', 'Membaca', 'Bermain bola', 'Bermain puzzle', 'Menari', 'Bernyanyi']),
                'cita_cita' => $faker->randomElement(['Dokter', 'Guru', 'Polisi', 'Tentara', 'Pilot', 'Arsitek', 'Dokter hewan']),
                'anak_ke' => $faker->numberBetween(1, 3),
                'jumlah_saudara' => $faker->numberBetween(0, 4),
                'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O']),
                'berat_badan' => round($faker->randomFloat(1, 12, 25), 1),
                'tinggi_badan' => round($faker->randomFloat(1, 85, 120), 1),
                'lingkar_kepala' => round($faker->randomFloat(1, 45, 52), 1),
                'imunisasi' => $faker->randomElement(['Lengkap', 'Sebagian', 'Belum lengkap']),
                'alamat_jalan' => $faker->streetAddress(),
                'alamat_kelurahan' => 'Kelurahan ' . $faker->city(),
                'alamat_kecamatan' => 'Kecamatan ' . $faker->city(),
                'alamat_kota' => $faker->city(),
                'alamat_provinsi' => $faker->randomElement(['Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'DKI Jakarta', 'Banten']),
                'kode_pos' => $faker->postcode(),
                'jarak_sekolah' => $faker->randomElement(['< 1 km', '1-3 km', '3-5 km', '> 5 km']),
                'telp_ayah' => '08' . $faker->numerify('##########'),
                'telp_ibu' => '08' . $faker->numerify('##########'),
                'nama_ayah' => $faker->name('male'),
                'nik_ayah' => $faker->numerify('################'),
                'tempat_lahir_ayah' => $faker->city(),
                'tanggal_lahir_ayah' => $tanggalLahirAyah->format('Y-m-d'),
                'pendidikan_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
                'pekerjaan_ayah' => $faker->randomElement(['PNS', 'Swasta', 'Wiraswasta', 'Guru', 'Dokter', 'Pegawai Bank', 'Karyawan']),
                'nama_ibu' => $faker->name('female'),
                'nik_ibu' => $faker->numerify('################'),
                'tempat_lahir_ibu' => $faker->city(),
                'tanggal_lahir_ibu' => $tanggalLahirIbu->format('Y-m-d'),
                'pendidikan_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
                'pekerjaan_ibu' => $faker->randomElement(['Ibu Rumah Tangga', 'PNS', 'Swasta', 'Guru', 'Bidan', 'Karyawan']),
            ]);
        }
        
        $this->command->info('Total 50 murid berhasil dibuat dengan data lengkap!');
    }
}
