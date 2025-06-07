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
            $table->id('user_id'); // ID user
            $table->string('name'); // Nama lengkap user
            $table->string('email')->unique(); // Email user, harus unik
            $table->timestamp('email_verified_at')->nullable(); // Waktu verifikasi email
            $table->string('password'); // Password user, harus di-hash
            $table->enum('role', ['admin', 'pelanggan', 'kurir']); // Role user, bisa admin, pelanggan, atau kurir
            $table->string('phone')->nullable(); // Nomor telepon user, bisa null
            $table->rememberToken(); // Token untuk "remember me" pada login
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Soft delete untuk menghapus data tanpa menghilangkan dari database
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
