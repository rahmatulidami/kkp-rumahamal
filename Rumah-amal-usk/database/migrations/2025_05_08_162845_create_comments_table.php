<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // ID komentar
            $table->unsignedBigInteger('post_id'); // ID post dari WordPress
            $table->unsignedBigInteger('parent_id')->nullable(); // ID komentar induk
            $table->text('content'); // Isi komentar
            $table->string('author'); // Nama pengirim komentar
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}