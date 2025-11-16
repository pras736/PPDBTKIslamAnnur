<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama_kelas' => 'Kelompok ' . $this->faker->randomElement(['A','B','C','D','E']),
            'nama_guru' => $this->faker->name(),
        ];
    }
}
