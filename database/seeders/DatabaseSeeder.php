<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Core user
        User::factory()->create([
            'name' => 'Test User',
            'nomor_induk' => '1234567890',
            'role' => 'admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        User::factory()->create([
            'name' => 'Test Mahasiswa',
            'nomor_induk' => '12454354745',
            'role' => 'mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => bcrypt('password'),
        ]);

        // application data
        $this->call([
            // CategorySeeder::class,
            // AnswerTemplateSeeder::class,
            // DefaultAnswerSeeder::class,
            // ModulHeaderSeeder::class,
            // ModulDetailSeeder::class,
            // QuestionSeeder::class,
            // AnswerSeeder::class,
        ]);
    }
}
