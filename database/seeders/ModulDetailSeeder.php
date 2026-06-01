<?php

namespace Database\Seeders;

use App\Models\ModulDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulDetailSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulDetail::create([
            'id_modul_header' => '1',
            'kategori_modul' => 'video',
            'name' => 'Introduction Video',
            'link' => 'https://example.com/intro',
        ]);
    }
}
