<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt(123),
          
        // ]);
        User::create([
            'id_user'=> '66548e20-da92-41a0-b064-8b6b35017d3d',
            'name' => 'farah',
            'email' => 'farah@example.com',
            'password' => bcrypt(123), 
            'role' => 'candidat',
        ]);

    }
}
