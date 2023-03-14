<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'Profile',
            'rol_id' => 1,
            'email' => 'admin@epn.edu.ec',
            'phone' => '0955555554',
            'address' => 'address 1',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Doctorcito',
            'lastname' => 'Altamirano',
            'rol_id' => 2,
            'email' => 'doc@epn.edu.ec',
            'phone' => '0955555789',
            'address' => 'address 2',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Juanito',
            'lastname' => 'Doctorcito',
            'rol_id' => 2,
            'email' => 'juandoc@epn.edu.ec',
            'phone' => '0955554568',
            'address' => 'address 10',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Jhon',
            'lastname' => 'Torres',
            'rol_id' => 3,
            'email' => 'jhon@epn.edu.ec',
            'phone' => '0955555471',
            'address' => 'address 3',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Mayra',
            'lastname' => 'Ñaupari',
            'rol_id' => 3,
            'email' => 'mayra@epn.edu.ec',
            'phone' => '0955555478',
            'address' => 'address 4',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Lesly',
            'lastname' => 'Herrera',
            'rol_id' => 3,
            'email' => 'lesly@epn.edu.ec',
            'phone' => '0955555400',
            'address' => 'address 5',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Nicole',
            'lastname' => 'Motoche',
            'rol_id' => 3,
            'email' => 'nico@epn.edu.ec',
            'phone' => '0955555474',
            'address' => 'address 6',
            'password' => bcrypt('password')
        ]);
    }
}
