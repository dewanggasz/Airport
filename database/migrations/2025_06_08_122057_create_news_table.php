<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul berita
            $table->string('slug')->unique(); // URL-friendly
            $table->text('content'); // Isi konten berita
            $table->string('image')->nullable(); // Path gambar thumbnail
            $table->date('published_at'); // Tanggal publikasi
            $table->boolean('is_visible')->default(false); // Status tampil/sembunyi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
