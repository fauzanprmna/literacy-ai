<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Conceptual Understanding of AI', 'bobot' => '1']);
        Category::create(['name' => 'Critical Evaluation of AI Output', 'bobot' => '1']);
        Category::create(['name' => 'Ethical & Responsible AI Awareness', 'bobot' => '1']);
        Category::create(['name' => 'Applied AI Use in Academic Context', 'bobot' => '1']);
    }
}
