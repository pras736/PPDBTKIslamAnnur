<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordPlainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update semua akun yang password_plain-nya null
        $akuns = Akun::whereNull('password_plain')->get();
        
        $defaultPasswords = [
            'admin' => 'admin123',
            'guru' => 'password',
            'wali' => 'password',
        ];
        
        $updated = 0;
        foreach ($akuns as $akun) {
            $defaultPassword = $defaultPasswords[$akun->role] ?? 'password123';
            
            // Update password hash juga untuk konsistensi
            $akun->update([
                'password' => Hash::make($defaultPassword),
                'password_plain' => $defaultPassword,
            ]);
            
            $updated++;
        }
        
        $this->command->info("Berhasil mengupdate {$updated} akun dengan password_plain.");
    }
}
