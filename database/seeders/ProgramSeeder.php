<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            'Axioo',
            'Intel',
            'MakeBlock',
            'Axioo Robotic',
            'TelView Security Academy',
            'Cerdas Bersama ASABA',
            'Digital Development',
            'Axioo Live Skill to Job & Enterpreneur',
            'LS Cable',
            'IT Specialist',
            'EL Shaddai',
            'Fablab Makers Academy',
            'Metrix Flasher',
            'IT Smart Coding'
        ];

        foreach ($programs as $program) {
            Program::insert([
                'name' => $program,
                'slug' => Str::slug($program)
            ]);
        }
    }
}
