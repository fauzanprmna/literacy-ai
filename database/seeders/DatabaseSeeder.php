<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Core user
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'nomor_induk' => '1234567890',
        //     'role' => 'admin',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        // ]);
        // User::factory()->create([
        //     'name' => 'Test Mahasiswa',
        //     'nomor_induk' => '12454354745',
        //     'role' => 'mahasiswa',
        //     'email' => 'mahasiswa@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // // application data
        // $this->call([
        //     // CategorySeeder::class,
        //     // AnswerTemplateSeeder::class,
        //     // DefaultAnswerSeeder::class,
        //     // ModulHeaderSeeder::class,
        //     // ModulDetailSeeder::class,
        //     // QuestionSeeder::class,
        //     // AnswerSeeder::class,
        // ]);

        // Create Learning Outcomes
        $outcomes = [
            [
                'name' => 'Conceptual Understanding',
                'slug' => 'conceptual_understanding',
                'description' => 'Pemahaman konsep dasar dan teori AI & Machine Learning',
                'target_score' => 70,
                'related_dimensions' => json_encode([
                    'UNDERSTANDING_AI',
                    'MACHINE_LEARNING',
                    'DEEP_LEARNING',
                    'DATA_SCIENCE'
                ]),
                'order' => 1
            ],
            [
                'name' => 'Application & Skills',
                'slug' => 'application_skills',
                'description' => 'Kemampuan untuk menerapkan AI/ML dalam praktik dan menggunakan tools',
                'target_score' => 70,
                'related_dimensions' => json_encode([
                    'MACHINE_LEARNING',
                    'DEEP_LEARNING',
                    'DATA_SCIENCE',
                    'NLP',
                    'COMPUTER_VISION',
                    'AI_APPLICATIONS',
                    'TOOLS_FRAMEWORKS'
                ]),
                'order' => 2
            ],
            [
                'name' => 'Critical Thinking',
                'slug' => 'critical_thinking',
                'description' => 'Kemampuan analisis kritis tentang implementasi dan strategi AI',
                'target_score' => 70,
                'related_dimensions' => json_encode([
                    'AI_APPLICATIONS',
                    'BUSINESS_AI',
                    'AI_GOVERNANCE',
                    'IMPACT_SOCIETY'
                ]),
                'order' => 3
            ],
            [
                'name' => 'Ethical Awareness',
                'slug' => 'ethical_awareness',
                'description' => 'Kesadaran akan etika, bias, dan dampak sosial dari AI',
                'target_score' => 70,
                'related_dimensions' => json_encode([
                    'ETHICAL_AI',
                    'AI_GOVERNANCE',
                    'IMPACT_SOCIETY',
                    'RESPONSIBLE_AI'
                ]),
                'order' => 4
            ]
        ];

        foreach ($outcomes as $outcome) {
            DB::table('learning_outcomes')->insert(array_merge(
                $outcome,
                ['created_at' => now(), 'updated_at' => now()]
            ));
        }

        // Create dimension mappings
        $mappings = [
            // Conceptual Understanding
            ['dimension_id' => 'UNDERSTANDING_AI', 'learning_outcome_id' => 1, 'mapping_weight' => 1.0],
            ['dimension_id' => 'MACHINE_LEARNING', 'learning_outcome_id' => 1, 'mapping_weight' => 0.9],
            ['dimension_id' => 'DEEP_LEARNING', 'learning_outcome_id' => 1, 'mapping_weight' => 0.8],
            ['dimension_id' => 'DATA_SCIENCE', 'learning_outcome_id' => 1, 'mapping_weight' => 0.7],

            // Application & Skills
            ['dimension_id' => 'MACHINE_LEARNING', 'learning_outcome_id' => 2, 'mapping_weight' => 1.0],
            ['dimension_id' => 'DEEP_LEARNING', 'learning_outcome_id' => 2, 'mapping_weight' => 0.9],
            ['dimension_id' => 'DATA_SCIENCE', 'learning_outcome_id' => 2, 'mapping_weight' => 0.9],
            ['dimension_id' => 'NLP', 'learning_outcome_id' => 2, 'mapping_weight' => 0.8],
            ['dimension_id' => 'COMPUTER_VISION', 'learning_outcome_id' => 2, 'mapping_weight' => 0.8],
            ['dimension_id' => 'AI_APPLICATIONS', 'learning_outcome_id' => 2, 'mapping_weight' => 0.7],

            // Critical Thinking
            ['dimension_id' => 'AI_APPLICATIONS', 'learning_outcome_id' => 3, 'mapping_weight' => 1.0],
            ['dimension_id' => 'BUSINESS_AI', 'learning_outcome_id' => 3, 'mapping_weight' => 0.9],
            ['dimension_id' => 'AI_GOVERNANCE', 'learning_outcome_id' => 3, 'mapping_weight' => 0.8],
            ['dimension_id' => 'IMPACT_SOCIETY', 'learning_outcome_id' => 3, 'mapping_weight' => 0.7],

            // Ethical Awareness
            ['dimension_id' => 'ETHICAL_AI', 'learning_outcome_id' => 4, 'mapping_weight' => 1.0],
            ['dimension_id' => 'AI_GOVERNANCE', 'learning_outcome_id' => 4, 'mapping_weight' => 0.9],
            ['dimension_id' => 'IMPACT_SOCIETY', 'learning_outcome_id' => 4, 'mapping_weight' => 0.8],
            ['dimension_id' => 'RESPONSIBLE_AI', 'learning_outcome_id' => 4, 'mapping_weight' => 0.7],
        ];

        foreach ($mappings as $mapping) {
            DB::table('dimension_learning_outcome_mapping')->insert(array_merge(
                $mapping,
                ['created_at' => now(), 'updated_at' => now()]
            ));
        }
    }
}
