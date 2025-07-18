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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id'); // ID unik untuk setiap notifikasi
            $table->foreignId('user_id')->constrained('users', 'user_id'); // ID user yang menerima notifikasi
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Pesan notifikasi
            $table->enum('type', ['info', 'warning', 'error', 'success'])->default('info'); // Tipe notifikasi
            $table->boolean('is_read')->default(false); // Status apakah notifikasi sudah dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
