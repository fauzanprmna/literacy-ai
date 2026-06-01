<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answer = [
            [
                'id_question' => '11',
                'name' => 'Algoritma terlalu kompleks',
                'bobot' => 0,
            ],
            [
                'id_question' => '11',
                'name' => 'Data tidak representatif',
                'bobot' => 2,
            ],
            [
                'id_question' => '11',
                'name' => 'AI tidak bisa belajar',
                'bobot' => 0,
            ],
            [
                'id_question' => '11',
                'name' => 'Sistem terlalu cepat',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '12',
                'name' => 'Tidak membutuhkan data',
                'bobot' => 0,
            ],
            [
                'id_question' => '12',
                'name' => 'Bergantung pada fitur yang digunakan',
                'bobot' => 2,
            ],
            [
                'id_question' => '12',
                'name' => 'Selalu objektif',
                'bobot' => 0,
            ],
            [
                'id_question' => '12',
                'name' => 'Tidak bisa salah',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '13',
                'name' => 'AI menjadi lebih cepat',
                'bobot' => 0,
            ],
            [
                'id_question' => '13',
                'name' => 'Data menjadi lebih akurat',
                'bobot' => 0,
            ],
            [
                'id_question' => '13',
                'name' => 'Prediksi tidak relevan dengan kondisi sekarang',
                'bobot' => 2,
            ],
            [
                'id_question' => '13',
                'name' => 'Tidak ada risiko',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '14',
                'name' => 'AI stabil',
                'bobot' => 0,
            ],
            [
                'id_question' => '14',
                'name' => 'AI sensitif terhadap data input',
                'bobot' => 2,
            ],
            [
                'id_question' => '14',
                'name' => 'AI tidak bekerja',
                'bobot' => 0,
            ],
            [
                'id_question' => '14',
                'name' => 'AI tidak membutuhkan data',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '15',
                'name' => 'Internet lambat',
                'bobot' => 0,
            ],
            [
                'id_question' => '15',
                'name' => 'Bias pada data pelatihan',
                'bobot' => 2,
            ],
            [
                'id_question' => '15',
                'name' => 'Layar rusak',
                'bobot' => 0,
            ],
            [
                'id_question' => '15',
                'name' => 'Kesalahan pengguna',
                'bobot' => 2,
            ],

            /* ===============================*/
            [
                'id_question' => '26',
                'name' => 'Langsung percaya',
                'bobot' => 0,
            ],
            [
                'id_question' => '26',
                'name' => 'Membagikan jawaban',
                'bobot' => 0,
            ],
            [
                'id_question' => '26',
                'name' => 'Memverifikasi dengan sumber lain',
                'bobot' => 2,
            ],
            [
                'id_question' => '26',
                'name' => 'Menghapus pertanyaan',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '27',
                'name' => 'Terlalu singkat',
                'bobot' => 0,
            ],
            [
                'id_question' => '27',
                'name' => 'Tidak dapat diverifikasi',
                'bobot' => 2,
            ],
            [
                'id_question' => '27',
                'name' => 'Terlalu kompleks',
                'bobot' => 0,
            ],
            [
                'id_question' => '27',
                'name' => 'Bahasa sulit',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '28',
                'name' => 'Pilih yang paling panjang',
                'bobot' => 0,
            ],
            [
                'id_question' => '28',
                'name' => 'Pilih yang pertama',
                'bobot' => 0,
            ],
            [
                'id_question' => '28',
                'name' => 'Bandingkan dengan sumber terpercaya',
                'bobot' => 2,
            ],
            [
                'id_question' => '28',
                'name' => 'Abaikan keduanya',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '29',
                'name' => 'AI selalu benar',
                'bobot' => 0,
            ],
            [
                'id_question' => '29',
                'name' => 'Output kemungkinan tidak akurat',
                'bobot' => 2,
            ],
            [
                'id_question' => '29',
                'name' => 'Data resmi salah',
                'bobot' => 2,
            ],
            [
                'id_question' => '29',
                'name' => 'Tidak perlu dicek',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '30',
                'name' => 'Machine learning',
                'bobot' => 0,
            ],
            [
                'id_question' => '30',
                'name' => ' Overfitting',
                'bobot' => 0,
            ],
            [
                'id_question' => '30',
                'name' => 'Hallucination AI',
                'bobot' => 2,
            ],
            [
                'id_question' => '30',
                'name' => 'Networking',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '41',
                'name' => 'Efisiensi belajar',
                'bobot' => 0,
            ],
            [
                'id_question' => '41',
                'name' => 'Pelanggaran etika akademik',
                'bobot' => 2,
            ],
            [
                'id_question' => '41',
                'name' => 'Kreativitas',
                'bobot' =>0,
            ],
            [
                'id_question' => '41',
                'name' => 'Inovasi',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '42',
                'name' => 'Plagiarisme',
                'bobot' => 0,
            ],
            [
                'id_question' => '42',
                'name' => 'Penggunaan AI yang bertanggung jawab',
                'bobot' => 2,
            ],
            [
                'id_question' => '42',
                'name' => 'Pelanggaran',
                'bobot' => 0,
            ],
            [
                'id_question' => '42',
                'name' => 'Kesalahan akademik',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '43',
                'name' => 'Tidak ada masalah',
                'bobot' => 0,
            ],
            [
                'id_question' => '43',
                'name' => 'Pelanggaran privasi',
                'bobot' => 2,
            ],
            [
                'id_question' => '43',
                'name' => 'Efisiensi kerja',
                'bobot' => 0,
            ],
            [
                'id_question' => '43',
                'name' => 'Inovasi teknologi',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '44',
                'name' => 'Meningkatkan kepercayaan',
                'bobot' => 0,
            ],
            [
                'id_question' => '44',
                'name' => 'Menyebarkan misinformasi',
                'bobot' => 2,
            ],
            [
                'id_question' => '44',
                'name' => 'Mempercepat belajar',
                'bobot' => 0,
            ],
            [
                'id_question' => '44',
                'name' => 'Menghemat waktu',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '45',
                'name' => 'Agar terlihat keren',
                'bobot' => 0,
            ],
            [
                'id_question' => '45',
                'name' => 'Untuk transparansi dan kejujuran',
                'bobot' => 2,
            ],
            [
                'id_question' => '45',
                'name' => 'Agar nilai tinggi',
                'bobot' => 0,
            ],
            [
                'id_question' => '45',
                'name' => 'Supaya cepat selesai',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '56',
                'name' => 'Tidak perlu diubah',
                'bobot' => 0,
            ],
            [
                'id_question' => '56',
                'name' => 'Tambahkan konteks spesifik',
                'bobot' => 2,
            ],
            [
                'id_question' => '56',
                'name' => 'Hapus pertanyaan',
                'bobot' => 0,
            ],
            [
                'id_question' => '56',
                'name' => 'Gunakan bahasa asing',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '57',
                'name' => 'Terlalu spesifik',
                'bobot' => 0,
            ],
            [
                'id_question' => '57',
                'name' => 'Tidak efektif dan berisiko plagiarisme',
                'bobot' => 2,
            ],
            [
                'id_question' => '57',
                'name' => 'Terlalu pendek',
                'bobot' => 0,
            ],
            [
                'id_question' => '57',
                'name' => 'Tidak bisa dijawab',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '58',
                'name' => 'Ketergantungan penuh',
                'bobot' => 0,
            ],
            [
                'id_question' => '58',
                'name' => 'Penggunaan efektif AI',
                'bobot' => 2,
            ],
            [
                'id_question' => '58',
                'name' => 'Pelanggaran',
                'bobot' => 0,
            ],
            [
                'id_question' => '58',
                'name' => ' Kesalahan',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '59',
                'name' => 'Umum dan singkat',
                'bobot' => 0,
            ],
            [
                'id_question' => '59',
                'name' => 'Tidak jelas',
                'bobot' => 0,
            ],
            [
                'id_question' => '59',
                'name' => 'Spesifik dan terarah',
                'bobot' => 2,
            ],
            [
                'id_question' => '59',
                'name' => 'Panjang tanpa tujuan',
                'bobot' => 0,
            ],

            /* ===============================*/
            [
                'id_question' => '60',
                'name' => 'Meningkatkan pemahaman',
                'bobot' => 0,
            ],
            [
                'id_question' => '60',
                'name' => 'Mengurangi kemampuan berpikir kritis',
                'bobot' => 2,
            ],
            [
                'id_question' => '60',
                'name' => 'Menambah kreativitas',
                'bobot' => 0,
            ],
            [
                'id_question' => '60',
                'name' => 'Tidak ada dampak',
                'bobot' => 0,
            ],
        ];

        foreach ($answer as $item) {
            Answer::create($item);
        }
    }
}
