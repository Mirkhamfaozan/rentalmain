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
        Schema::create('rental_biodata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nama_rental');                  // Nama perusahaan / usaha
            $table->string('nama_pemilik');                 // Nama pemilik rental
            $table->string('alamat');                       // Alamat lengkap
            $table->string('kota');                         // Kota/kabupaten
            $table->string('provinsi');                     // Provinsi
            $table->string('kode_pos')->nullable();         // Kode pos
            $table->string('no_telepon');                   // Nomor telepon kantor
            $table->string('no_wa')->nullable();            // WhatsApp (jika berbeda)
            $table->string('email_perusahaan')->nullable(); // Email perusahaan
            $table->string('npwp')->nullable();             // NPWP (jika ada)
            $table->string('siup')->nullable();             // SIUP (jika ada)
            $table->string('foto_ktp')->nullable();         // Upload KTP pemilik (URL/file path)
            $table->string('foto_npwp')->nullable();        // Upload NPWP (URL/file path)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_biodata');
    }
};
