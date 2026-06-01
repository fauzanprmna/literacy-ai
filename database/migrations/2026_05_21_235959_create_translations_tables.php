<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Question translations
        Schema::create('question_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->string('locale', 10)->index();
            // optional header/title in translation and the full question text
            $table->string('header')->nullable();
            $table->text('question')->nullable();
            $table->timestamps();
            $table->unique(['question_id', 'locale']);
        });

        // Answer translations
        Schema::create('answer_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->constrained('answers')->onDelete('cascade');
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->unique(['answer_id', 'locale']);
        });

        // Default answer translations
        Schema::create('default_answer_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_answer_id')->constrained('default_answers')->onDelete('cascade');
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->unique(['default_answer_id', 'locale']);
        });

        // Modul translations
        Schema::create('modul_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_id')->constrained('moduls')->onDelete('cascade');
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->text('isi')->nullable();
            $table->timestamps();
            $table->unique(['modul_id', 'locale']);
        });

        // Category translations
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('modul_translations');
        Schema::dropIfExists('default_answer_translations');
        Schema::dropIfExists('answer_translations');
        Schema::dropIfExists('question_translations');
    }
};
