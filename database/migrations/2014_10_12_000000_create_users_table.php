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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id'); // ID user, auto-increment sebagai primary key
            $table->string('name', 100); // Nama lengkap user
            $table->string('email', 100)->unique(); // Email user, harus unik
            $table->timestamp('email_verified_at')->nullable(); // Waktu verifikasi email
            $table->string('password', 100); // Password user, harus di-hash
            $table->enum('role', ['admin', 'pelanggan', 'kurir'])->default('pelanggan'); // Role user, bisa admin, pelanggan, atau kurir
            $table->string('phone', 25)->nullable(); // Nomor telepon user, bisa null
            $table->rememberToken(); // Token untuk "remember me" pada login
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Soft delete untuk menghapus data tanpa menghilangkan dari database
            $table->comment('Tabel ini menyimpan informasi pengguna aplikasi, termasuk nama, email, password, role, dan nomor telepon. Role dapat berupa admin, pelanggan, atau kurir. Tabel ini juga mendukung soft delete untuk menghapus data tanpa menghilangkan dari database.'); // Deskripsi tabel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
