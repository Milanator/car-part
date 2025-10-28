<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        $car = Car::first();

        $car->parts()->create([
            'name' => 'Brzdový kotúč',
            'serial_number' => 'AAAAA',
        ]);

        $car->parts()->create([
            'name' => 'Olejový filter',
            'serial_number' => 'BBBB',
        ]);
    }
}
