<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoCita;

class EstadoCitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoCita::create([
            'description' => 'disponible',
        ]);
        EstadoCita::create([
            'description' => 'no disponible',
        ]);
    }
}
