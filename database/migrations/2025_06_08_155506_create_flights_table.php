<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ..._create_flights_table.php
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel airlines
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->string('flight_number'); // Cth: GA-202
            $table->enum('direction', ['departure', 'arrival']); // Arah penerbangan
            $table->string('city'); // Kota Asal atau Tujuan
            $table->dateTime('scheduled_time'); // Waktu sesuai jadwal
            $table->dateTime('actual_time')->nullable(); // Waktu aktual (bisa diisi nanti)
            $table->enum('status', ['Scheduled', 'On Time', 'Delayed', 'Departed', 'Landed', 'Cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
