<?php

namespace Database\Seeders;

use App\Models\DefaultAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultAnswerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultAnswers = [
            [
                'id_answer_template' => 1,
                'name' => 'Sangat Tidak Setuju',
                'bobot' => '1',
            ],
            [
                'id_answer_template' => 1,
                'name' => 'Tidak Setuju',
                'bobot' => '2',
            ],
            [
                'id_answer_template' => 1,
                'name' => 'Setuju',
                'bobot' => '3',
            ],
            [
                'id_answer_template' => 1,
                'name' => 'Sangat Setuju',
                'bobot' => '4',
            ],
        ];
        
        foreach ($defaultAnswers as $answer) {
            DefaultAnswer::create($answer);
        }
    }
}
