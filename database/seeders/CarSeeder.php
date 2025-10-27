<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        Car::create([
            'name' => 'Škoda combi',
            'registration_number' => 'ABCDE',
            'is_registered' => true,
        ]);

        Car::create([
            'name' => 'Toyota Corolla',
            'registration_number' => '1234AB',
            'is_registered' => false,
        ]);
    }
}
