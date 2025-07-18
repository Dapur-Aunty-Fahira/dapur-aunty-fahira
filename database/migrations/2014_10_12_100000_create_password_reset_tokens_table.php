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
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 100)->primary();
            $table->string('token', 100)->unique();
            $table->timestamp('created_at')->nullable();
            $table->comment('Tabel ini menyimpan token reset password untuk pengguna. Setiap token terkait dengan email pengguna dan memiliki waktu pembuatan. Token ini digunakan untuk mengamankan proses reset password.'); // Deskripsi tabel
            $table->index('token'); // Index untuk token untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
