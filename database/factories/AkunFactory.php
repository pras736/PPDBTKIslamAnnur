<?php

namespace Database\Factories;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AkunFactory extends Factory
{
    protected $model = Akun::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['wali', 'guru']),
        ];
    }
}
