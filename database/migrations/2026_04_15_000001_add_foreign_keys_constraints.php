<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clean orphaned records
        DB::table('default_answers')->whereNotIn('id_answer_template', DB::table('answer_templates')->select('id'))->delete();
        DB::table('answers')->whereNotIn('id_question', DB::table('questions')->select('id'))->delete();
        DB::table('questions')->whereNotIn('id_kategori', DB::table('categories')->select('id'))->delete();
        DB::table('questions')->whereNotNull('id_answer_template')->whereNotIn('id_answer_template', DB::table('answer_templates')->select('id'))->delete();
        DB::table('moduls')->whereNotNull('id_kategori_modul')->whereNotIn('id_kategori_modul', DB::table('kategori_moduls')->select('id'))->delete();
        DB::table('moduls')->whereNotNull('id_kategori')->whereNotIn('id_kategori', DB::table('categories')->select('id'))->delete();

        // Drop existing FKs if they exist
        $this->dropForeignKeysIfExist();

        // Add FKs
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_answer_template')->references('id')->on('answer_templates')->onDelete('set null');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('id_question')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::table('default_answers', function (Blueprint $table) {
            $table->foreign('id_answer_template')->references('id')->on('answer_templates')->onDelete('cascade');
        });

        Schema::table('moduls', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_kategori_modul')->references('id')->on('kategori_moduls')->onDelete('cascade');
        });
        

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('default_answers', function (Blueprint $table) {
            $table->dropForeign(['id_answer_template']);
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['id_question']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_answer_template']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function dropForeignKeysIfExist(): void
    {
        $tables = ['questions', 'answers', 'default_answers', 'modul_headers', 'modul_details'];

        foreach ($tables as $table) {
            $keyConstraints = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME='$table' AND COLUMN_NAME IN ('id_kategori', 'id_answer_template', 'id_question', 'id_modul_header') AND REFERENCED_TABLE_NAME IS NOT NULL");

            foreach ($keyConstraints as $constraint) {
                try {
                    DB::statement("ALTER TABLE $table DROP FOREIGN KEY " . $constraint->CONSTRAINT_NAME);
                } catch (\Exception $e) {
                    // silently ignore if constraint doesn't exist
                }
            }
        }
    }
};
