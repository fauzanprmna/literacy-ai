<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom is_correct ke tabel answers untuk menandai
     * apakah suatu jawaban pilihan ganda adalah jawaban yang benar.
     * Kolom bobot pada answers tetap digunakan, namun is_correct
     * menjadi sumber kebenaran utama untuk penilaian pilihan ganda.
     */
    public function up(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            // Flag eksplisit: apakah jawaban ini merupakan jawaban benar
            $table->boolean('is_correct')->default(false)->after('name');
        });

        // Migrate data lama: bobot=1 dianggap benar, bobot=0 salah
        // Hanya berlaku untuk jawaban MC (id_question join ke questions.type = 'multiple_choice')
        DB::statement("
            UPDATE answers a
            INNER JOIN questions q ON a.id_question = q.id
            SET a.is_correct = (a.bobot = 1)
            WHERE q.type = 'multiple_choice'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('is_correct');
        });
    }
};
