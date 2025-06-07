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
            $table->id(); // ID unik untuk setiap alamat
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID user yang memiliki alamat
            $table->string('recipient_name'); // Nama penerima alamat
            $table->string('phone'); // Nomor telepon penerima
            $table->string('address'); // Baris alamat pertama
            $table->string('city'); // Kota atau kabupaten
            $table->string('state'); // Provinsi atau negara bagian
            $table->string('country')->default('Indonesia'); // Negara, default Indonesia
            $table->string('postal_code'); // Kode pos
            $table->string('coordinates')->nullable(); // Koordinat alamat (latitude, longitude), bisa null
            $table->text('notes')->nullable(); // Catatan tambahan untuk alamat, bisa null
            $table->boolean('is_default')->default(false); // Apakah alamat ini adalah alamat default
            $table->boolean('is_active')->default(true); // Status aktif alamat
            $table->softDeletes(); // Kolom untuk soft delete
            $table->timestamps();
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
