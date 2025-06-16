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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama maskapai, cth: Garuda Indonesia
            $table->string('iata_code', 3)->unique(); // Kode IATA unik, cth: GA
            $table->string('logo')->nullable(); // Path untuk menyimpan logo
            $table->timestamps();
        });
    }   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
