<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $questions = [

            /* ===============================
            Conceptual Understanding of AI
            =============================== */

            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa sistem AI bekerja dengan mempelajari pola dari data.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa kualitas data sangat mempengaruhi hasil yang diberikan oleh sistem AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya mengetahui bahwa AI tidak benar-benar “berpikir”, tetapi memproses data menggunakan algoritma.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa AI dapat membuat kesalahan meskipun jawabannya terlihat meyakinkan.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya mengetahui bahwa AI generatif menghasilkan konten baru berdasarkan data yang dipelajarinya.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa model AI dilatih menggunakan dataset dalam jumlah besar.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya mengetahui bahwa AI dapat memiliki bias jika data pelatihannya bias.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami perbedaan antara kecerdasan buatan (AI), machine learning, dan deep learning.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya mengetahui bahwa AI tidak selalu memiliki akses ke informasi terbaru.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa AI hanyalah alat bantu yang dikembangkan oleh manusia.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'question' => 'Seorang mahasiswa menggunakan AI untuk memprediksi nilai mahasiswa berdasarkan data sebelumnya. Namun, data yang digunakan hanya berasal dari satu jurusan.
                                \nApa masalah utama dari sistem AI tersebut?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'question' => 'AI menghasilkan rekomendasi kampus terbaik, tetapi tidak mempertimbangkan biaya kuliah.
                                Hal ini menunjukkan bahwa AI...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'question' => 'Sebuah model AI dilatih menggunakan data lama (tahun 2010–2015), lalu digunakan untuk kondisi saat ini.
                                \nApa risiko utamanya?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'question' => 'AI memberikan hasil berbeda ketika data input diubah sedikit.
                                \nHal ini menunjukkan bahwa...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 1,
                'question' => 'Sistem AI mendeteksi wajah tetapi sering gagal mengenali kelompok tertentu.
                                \nMasalah ini kemungkinan disebabkan oleh...',
                'bobot' => 1
            ],


            /* ===============================
            Critical Evaluation of AI Output
            =============================== */

            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya memeriksa kembali informasi yang diberikan AI sebelum menggunakannya.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya membandingkan jawaban AI dengan sumber lain seperti jurnal atau buku.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya menyadari bahwa jawaban AI bisa saja mengandung kesalahan.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya mengevaluasi apakah informasi yang diberikan AI relevan dengan kebutuhan saya.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya mempertimbangkan keakuratan informasi sebelum menggunakan output AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya mencoba mengidentifikasi kemungkinan bias dalam jawaban AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya tidak langsung mempercayai semua informasi yang diberikan AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya menilai apakah jawaban AI memiliki dasar informasi yang jelas.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya menggunakan beberapa sumber untuk memastikan kebenaran informasi dari AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'id_answer_template' => 1,
                'question' => 'Saya mempertimbangkan kredibilitas informasi sebelum menggunakan output AI dalam tugas akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'question' => 'AI menjawab: “Semua negara di Asia adalah negara berkembang.”
                                \nApa langkah terbaik?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'question' => 'AI memberikan jawaban panjang tetapi tanpa sumber.
                                \nApa masalah utamanya?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'question' => 'Dua AI memberikan jawaban berbeda untuk pertanyaan yang sama.
                                \nApa yang harus dilakukan?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'question' => 'AI menghasilkan data statistik, tetapi angkanya tidak sesuai dengan data resmi.
                                \nApa indikasinya?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 2,
                'question' => 'AI memberikan jawaban yang terdengar meyakinkan tetapi ternyata salah.
                                \nFenomena ini disebut...',
                'bobot' => 1
            ],


            /* ===============================
            Ethical & Responsible AI Awareness
            =============================== */

            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya memahami pentingnya menggunakan AI secara jujur dalam kegiatan akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya menyadari bahwa penggunaan AI tanpa pengakuan dapat melanggar etika akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya mempertimbangkan aspek privasi saat menggunakan AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa penggunaan AI harus dilakukan secara bertanggung jawab.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya merasa penting untuk transparan dalam penggunaan AI dalam tugas atau penelitian.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya menghindari penggunaan AI untuk melakukan plagiarisme.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa AI dapat berdampak pada masyarakat jika digunakan secara tidak bertanggung jawab.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya mempertimbangkan dampak sosial dari penggunaan teknologi AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya berusaha menggunakan AI secara etis dalam kegiatan akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'id_answer_template' => 1,
                'question' => 'Saya memahami bahwa AI harus digunakan dengan memperhatikan aturan dan kebijakan akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'question' => 'Seorang mahasiswa menyalin hasil AI ke tugas tanpa mengedit atau mencantumkan sumber.
                                \nIni termasuk...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'question' => 'Mahasiswa menggunakan AI untuk membantu memahami materi, lalu menulis ulang dengan bahasanya sendiri.
                                \nIni termasuk...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'question' => 'Seseorang memasukkan data pribadi orang lain ke dalam AI tanpa izin.
                                \nApa masalahnya?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'question' => 'AI digunakan untuk membuat berita palsu.
                                \nDampaknya adalah...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 3,
                'question' => 'Mengapa penting menyebutkan penggunaan AI dalam tugas akademik?',
                'bobot' => 1
            ],


            /* ===============================
            Applied AI Use in Academic Context
            =============================== */

            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya dapat menggunakan AI untuk membantu memahami materi perkuliahan.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya menggunakan AI untuk membantu mencari informasi akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya dapat menggunakan AI untuk merangkum teks akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya dapat menyusun prompt yang jelas ketika menggunakan AI.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya menggunakan AI sebagai alat bantu, bukan sebagai pengganti pemikiran saya sendiri.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya dapat menggunakan AI untuk membantu menyusun ide dalam penulisan akademik.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya menggunakan AI untuk meningkatkan efisiensi belajar atau penelitian.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya dapat memanfaatkan AI untuk membantu analisis informasi.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya mampu mengintegrasikan AI dalam proses belajar atau mengajar.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'id_answer_template' => 1,
                'question' => 'Saya merasa AI dapat membantu meningkatkan produktivitas akademik saya.',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'question' => 'Prompt: “Jelaskan AI.”
                                \nHasilnya terlalu umum. Bagaimana memperbaikinya?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'question' => 'Prompt: “Buatkan skripsi lengkap tentang AI.”
                                \nApa masalah utama?',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'question' => 'Mahasiswa menggunakan AI untuk merangkum jurnal, lalu membaca ulang hasilnya.
                                \nIni merupakan...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'question' => 'Prompt yang baik seharusnya...',
                'bobot' => 1
            ],
            [
                'id_kategori' => 4,
                'question' => 'Mahasiswa hanya menyalin hasil AI tanpa memahami isi.
                                \nDampaknya adalah...',
                'bobot' => 1
            ]

        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
