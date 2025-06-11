    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('nama_motor', 100);
                $table->string('brand', 50);
                $table->integer('cc_motor');

                // Pricing fields
                $table->decimal('harga_harian', 15, 2);
                $table->decimal('harga_mingguan', 15, 2)->comment('Harga untuk 5 hari (7-2)');
                $table->decimal('harga_bulanan', 15, 2)->comment('Harga untuk 15 hari (30-15)');
                $table->integer('diskon_mingguan')->default(2)->comment('Pengurangan hari untuk paket mingguan');
                $table->integer('diskon_bulanan')->default(15)->comment('Pengurangan hari untuk paket bulanan');

                $table->string('transmisi_motor', 20);
                $table->string('nomor_stnk', 50)->nullable();
                $table->string('nomor_kendaraan', 50)->nullable();
                $table->string('foto_stnk')->nullable()->comment('Photo of STNK document');
                $table->string('tipe_motor', 50);
                $table->year('tahun_produksi');
                $table->string('warna', 50);
                $table->string('no_mesin', 50)->unique();
                $table->string('no_rangka', 50)->unique();
                $table->string('gambar_utama');
                $table->text('deskripsi')->nullable();
                $table->integer('stok')->default(0);
                $table->boolean('is_available')->default(true);
                $table->softDeletes();
                $table->timestamps();

                $table->index(['brand', 'is_available']);
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('products');
        }
    };
