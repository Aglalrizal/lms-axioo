<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'berita'],
            ['name' => 'akademi'],
            ['name' => 'event'],
            ['name' => 'tutorial'],
        ];
        BlogCategory::insert($data);
    }
}
