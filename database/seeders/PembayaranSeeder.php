<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;
use App\Models\Murid;
use Faker\Factory as Faker;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $murids = Murid::all();

        // Buat pembayaran untuk semua murid (setiap murid bisa punya 1-3 pembayaran)
        foreach ($murids as $murid) {
            // 70% murid punya pembayaran
            if ($faker->boolean(70)) {
                $jumlahPembayaran = $faker->numberBetween(1, 3);
                
                for ($i = 0; $i < $jumlahPembayaran; $i++) {
                    $status = $faker->randomElement(['menunggu', 'diverifikasi', 'ditolak']);
                    
                    Pembayaran::create([
                        'id_murid' => $murid->id_murid,
                        'bukti_pembayaran' => $status === 'diverifikasi' 
                            ? 'bukti_pembayaran_' . $murid->id_murid . '_' . ($i + 1) . '.jpg' 
                            : null,
                        'status_pembayaran' => $status,
                        'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                        'updated_at' => $faker->dateTimeBetween('-3 months', 'now'),
                    ]);
                }
            }
        }
        
        $totalPembayaran = Pembayaran::count();
        $verified = Pembayaran::where('status_pembayaran', 'diverifikasi')->count();
        $pending = Pembayaran::where('status_pembayaran', 'menunggu')->count();
        $rejected = Pembayaran::where('status_pembayaran', 'ditolak')->count();
        
        $this->command->info("Total {$totalPembayaran} pembayaran berhasil dibuat!");
        $this->command->info("  - Diverifikasi: {$verified}");
        $this->command->info("  - Menunggu: {$pending}");
        $this->command->info("  - Ditolak: {$rejected}");
    }
}
