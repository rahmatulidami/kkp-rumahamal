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
                // Tambah kolom di komentar
        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            // $table->unsignedBigInteger('user_id')->nullable(); // Lebih baik jika ingin relasi ke users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            //
        });
    }
};
