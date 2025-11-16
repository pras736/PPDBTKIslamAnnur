<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = Akun::where('username', 'admin')->where('role', 'admin')->exists();
        
        if (!$adminExists) {
            Akun::create([
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'password_plain' => 'admin123',
                'role' => 'admin',
            ]);
            
            $this->command->info('Akun admin default berhasil dibuat!');
            $this->command->info('Username: admin');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Akun admin sudah ada.');
        }
    }
}

