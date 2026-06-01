<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('modul_contents')) {
            Schema::create('modul_contents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('modul_id')->constrained('moduls')->onDelete('cascade');
                $table->enum('type', ['text', 'file', 'link']); // text, file, atau link/video
                // For text type: bilingual content
                $table->longText('content_id')->nullable(); // untuk type text (Indonesia)
                $table->longText('content_en')->nullable(); // untuk type text (English)
                // For file type
                $table->string('file_path')->nullable(); // untuk type file
                // For link type
                $table->string('url')->nullable(); // untuk type link/video
                $table->unsignedInteger('order')->default(0); // urutan konten
                $table->timestamps();
                $table->index('modul_id');
                $table->index('order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_contents');
    }
};
