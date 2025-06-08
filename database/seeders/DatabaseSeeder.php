<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
       User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'pria',
       ]);
       User::create([
            'nama' => 'Admin',
            'email' => 'admin@admin',
              'password' => Hash::make('admin123'),
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'pria',
       ]);
    }
}
