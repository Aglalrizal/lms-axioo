<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        
        //akun admin
        $admin = User::factory()->create([
            'username' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');
        
        // dummy akun students
        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('student');
        });

        // dummy akun instructors
        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('instructor');
        });

    }
}
