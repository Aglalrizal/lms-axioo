<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use App\Models\Blog;
use App\Models\SupportTicket;
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
        $this->call(BlogCategorySeeder::class);

        CourseCategory::factory(5)->create();

        //akun admin
        $admin = User::factory()->create([
            'username' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('password')
        ]);
        $admin2 = User::factory()->create([
            'username' => 'Admin 2',
            'email' => 'super2@admin.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('super-admin');
        $admin2->assignRole('super-admin');
        $manageFaq = Permission::firstOrCreate(['name' => 'manage faqs']);
        $admin->givePermissionTo($manageFaq);
        $admin2->givePermissionTo($manageFaq);

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

        SupportTicket::factory(50)->create();
        // Blog::factory(50)->create();
    }
}
