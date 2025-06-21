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

            // Kolom untuk dokumen pendukung
            $table->string('foto_ktp')->nullable();         // Path foto KTP pemilik
            $table->string('foto_surat_izin_usaha')->nullable(); // Path foto surat izin usaha
            $table->string('foto_tempat')->nullable();      // Path foto tempat usaha rental

            // Status verifikasi
            $table->enum('status_verifikasi', ['belum_verifikasi', 'terverifikasi', 'ditolak'])
                  ->default('belum_verifikasi');            // Status verifikasi rental
            $table->text('catatan_verifikasi')->nullable(); // Catatan dari admin saat verifikasi
            $table->timestamp('tanggal_verifikasi')->nullable(); // Tanggal verifikasi
            $table->foreignId('verified_by')->nullable()->constrained('users'); // Admin yang verifikasi

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
