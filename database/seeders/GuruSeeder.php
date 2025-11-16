<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Nama-nama guru Indonesia
        $namaGuru = [
            'Bu Siti Nurhaliza',
            'Bu Dewi Sartika',
            'Bu Kartini',
            'Bu Fatimah Azzahra',
            'Bu Aisyah R.A.',
            'Bu Khadijah',
            'Pak Ahmad Dahlan',
            'Pak Muhammad Natsir',
            'Pak Haji Agus Salim',
            'Pak Abdul Kahar Muzakkar'
        ];

        // Buat 10 guru dengan data lengkap
        for ($i = 0; $i < 10; $i++) {
            $nama = $namaGuru[$i] ?? 'Guru ' . ($i + 1);
            $username = strtolower(str_replace([' ', "'", '.'], '', explode(' ', $nama)[count(explode(' ', $nama)) - 1])) . ($i + 1);
            
            $akun = Akun::create([
                'username' => $username,
                'password' => Hash::make('password'),
                'password_plain' => 'password',
                'role' => 'guru',
            ]);

            Guru::create([
                'id_akun' => $akun->id_akun,
                'NIP' => 'NIP-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT) . '-' . date('Y'),
                'kelas' => null,
            ]);
            
            $this->command->info("Guru dibuat: {$username} (password: password)");
        }
        
        $this->command->info('Total 10 guru berhasil dibuat!');
    }
}
