<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(FaqCategorySeeder::class);
        $this->call(FaqSeeder::class);
        
        //akun admin
        $admin = User::factory()->create([
            'username' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('super-admin');
        $manageFaq = Permission::firstOrCreate(['name' => 'manage faqs']);
        $admin->givePermissionTo($manageFaq);
        
        // dummy akun admin
        User::factory(3)->create()->each(function ($user) {
            $user->assignRole('admin');
        });
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
