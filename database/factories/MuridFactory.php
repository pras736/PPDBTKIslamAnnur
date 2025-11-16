<?php

namespace Database\Factories;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Factories\Factory;

class MuridFactory extends Factory
{
    protected $model = Murid::class;

    public function definition(): array
    {
        return [
            'status_siswa' => 'aktif',
            'no_induk_sekolah' => $this->faker->unique()->numerify('ND###'),
            'nama_lengkap' => $this->faker->name(),
            'nama_panggilan' => $this->faker->firstName(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-7 years', '-3 years')->format('Y-m-d'),
            'agama' => 'Islam',
            'alamat_jalan' => $this->faker->streetAddress(),
            'alamat_kota' => $this->faker->city(),
            'kode_pos' => $this->faker->postcode(),
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'telp_ayah' => $this->faker->phoneNumber(),
        ];
    }
}
