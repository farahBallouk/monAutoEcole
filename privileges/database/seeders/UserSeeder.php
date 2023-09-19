<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'moniteur',
            'email' => 'moniteur@gmail.com',
            'role'  => 'moniteur',
            'password' => bcrypt('passmoniteur')
        ]);
        $user1->assignRole(Role::where('name', $user1->role)->first());

        $user2 = User::create([
            'name' => 'candidat',
            'email' => 'candidat@gmail.com',
            'role'  => 'candidat',
            'password' => bcrypt('passcandidat')
        ]);
        $user2->assignRole(Role::where('name', $user2->role)->first());

        $user3 = User::create([
            'name' => 'autoecole',
            'email' => 'autoecole@gmail.com',
            'role'  => 'autoecole',
            'password' => bcrypt('passautoecole')
        ]);
        $user3->assignRole(Role::where('name', $user3->role)->first());

        $user4 = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'role'  => 'superadmin',
            'password' => bcrypt('passsuperadmin')
        ]);
        $user4->assignRole(Role::where('name', $user4->role)->first());
    }
}
