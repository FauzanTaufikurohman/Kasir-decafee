<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@superadmin.com',
            'password' => bcrypt('password'),
            'level' => 1,
        ]);
         User::factory()->create([
            'name' => 'Kasir Handsome',
            'email' => 'kasir@kasir.com',
            'password' => bcrypt('password'),
            'level' => 2,
        ]);
        
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'level' => 3,
        ]);
        User::factory()->create([
            'name' => 'Dapur Barbar',
            'email' => 'dapur@dapur.com',
            'password' => bcrypt('password'),
            'level' => 4,
        ]);
    }
}
