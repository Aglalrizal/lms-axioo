<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'berita', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'akademi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'event', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'tutorial', 'created_at' => now(), 'updated_at' => now()],
        ];
        BlogCategory::query()->insert($data);
    }
}
