<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'most asked', 'order' => 1],
            ['name' => 'general inquiries', 'order' => 1],
            ['name' => 'support', 'order' => 3],
        ];
        FaqCategory::insert($data);
    }
}
