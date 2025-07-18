<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->increments('address_id'); // ID unik untuk setiap alamat pelanggan
            $table->integer('user_id')->unsigned(); // ID user yang memiliki alamat
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // Foreign key ke users.user_id
            $table->string('recipient_name', 100); // Nama penerima alamat
            $table->string('phone', 25); // Nomor telepon penerima
            $table->string('address', 255); // Baris alamat pertama
            $table->string('city', 100); // Kota atau kabupaten
            $table->string('state', 100); // Provinsi atau negara bagian
            $table->string('country', 100)->default('Indonesia'); // Negara, default Indonesia
            $table->string('postal_code', 20); // Kode pos
            $table->string('coordinates')->nullable(); // Koordinat alamat (latitude, longitude), bisa null
            $table->text('notes')->nullable(); // Catatan tambahan untuk alamat, bisa null
            $table->boolean('is_default')->default(false); // Apakah alamat ini adalah alamat default
            $table->boolean('is_active')->default(true); // Status aktif alamat
            $table->softDeletes(); // Kolom untuk soft delete
            $table->timestamps();
            $table->unique(['user_id', 'address'], 'unique_user_address'); // Unik kombinasi user_id dan address untuk mencegah duplikasi alamat
            $table->index('user_id'); // Index untuk user_id untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
            $table->index('updated_at'); // Index untuk updated_at untuk performa query
            $table->index('deleted_at'); // Index untuk deleted_at untuk performa query pada soft deletes
            $table->comment('Tabel ini menyimpan informasi alamat pelanggan, termasuk nama penerima, nomor telepon, alamat, kota, provinsi, negara, kode pos, koordinat, catatan tambahan, dan status alamat. Alamat dapat ditandai sebagai default dan aktif.'); // Deskripsi tabel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
