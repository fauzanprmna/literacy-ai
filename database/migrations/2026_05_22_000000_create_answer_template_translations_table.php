<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('answer_template_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_template_id')->constrained('answer_templates')->onDelete('cascade');
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->unique(['answer_template_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answer_template_translations');
    }
};
