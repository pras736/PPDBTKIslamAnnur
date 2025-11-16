<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition(): array
    {
        return [
            'bukti_pembayaran' => null,
            'status_pembayaran' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
        ];
    }
}
