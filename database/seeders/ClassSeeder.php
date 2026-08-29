<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Classes::firstOrCreate(
            ['class_name' => 'Grade1', 'section' => 'A'],
            ['academic_year' => '2025-2026']
        );
    }
}
