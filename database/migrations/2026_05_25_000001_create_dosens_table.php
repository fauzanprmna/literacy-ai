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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nidn')->nullable()->unique();
            $table->string('nuptk')->nullable()->unique();
            $table->string('prodi')->nullable();
            $table->string('email_institusi')->nullable()->unique();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('gelar_akademik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
