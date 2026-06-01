<?php

namespace Database\Seeders;

use App\Models\KategoriModul;
use App\Models\Modul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulHeaderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori_modul = [
            ['icon' => 'fa-regular fa-note-stick', 'name' => 'Text'],
            ['icon' => 'fa-solid fa-file', 'name' => 'File'],
            ['icon' => 'fa-solid fa-link', 'name' => 'Link'],
        ];
        foreach ($kategori_modul as $modul) {
            KategoriModul::create($modul);
        }

        $modul_header = [
            ['name' => 'Modul 1', 'id_kategori_modul' => 1, 'id_kategori' => 1, 'isi' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
            ['name' => 'Modul 2', 'id_kategori_modul' => 2, 'id_kategori' => 1, 'link' => 'https://example.com/file.pdf'],
            ['name' => 'Modul 3', 'id_kategori_modul' => 3, 'id_kategori' => 1, 'link' => 'https://example.com/file.pdf'],
        ];
        foreach ($modul_header as $modul) {
            Modul::create($modul);
        }
    }
}
