<?php

namespace Database\Seeders;

use App\Models\AnswerTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerTemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnswerTemplate::create(['name' => 'Template 1']);
    }
}
