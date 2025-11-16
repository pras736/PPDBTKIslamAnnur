<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Murid;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::take(5)->get();
        $names = ['A', 'B', 'C', 'D', 'E'];
        $murids = Murid::where('status_siswa', 'terdaftar')->get();

        foreach ($names as $index => $suffix) {
            $guru = $gurus->get($index) ?? null;
            
            $namaKelas = 'Kelompok ' . $suffix;
            $namaGuru = $guru && $guru->akun 
                ? ($guru->akun->username ?? 'Guru ' . ($index + 1))
                : 'Guru ' . ($index + 1);

            $kelas = Kelas::create([
                'id_guru' => $guru ? $guru->id_guru : null,
                'nama_kelas' => $namaKelas,
                'nama_guru' => $namaGuru,
            ]);

            // Assign murid ke kelas (10 murid per kelas jika ada cukup murid terdaftar)
            $muridsKelas = $murids->skip($index * 10)->take(10);
            $countAssigned = 0;
            foreach ($muridsKelas as $murid) {
                try {
                    $murid->update(['id_kelas' => $kelas->id_kelas]);
                    $countAssigned++;
                } catch (\Exception $e) {
                    // Skip if id_kelas column doesn't exist
                    break;
                }
            }
            
            $this->command->info("Kelas {$namaKelas} dibuat dengan {$countAssigned} murid");
        }
        
        $this->command->info('Total 5 kelas berhasil dibuat!');
    }
}
