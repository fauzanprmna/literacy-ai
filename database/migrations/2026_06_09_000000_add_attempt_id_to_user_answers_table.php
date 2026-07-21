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
        if (! Schema::hasColumn('user_answers', 'attempt_id')) {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->unsignedBigInteger('attempt_id')->nullable()->after('question_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('user_answers', 'attempt_id')) {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->dropColumn('attempt_id');
            });
        }
    }
};
