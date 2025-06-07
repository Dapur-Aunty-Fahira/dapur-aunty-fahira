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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_number', 50)->primary(); // Nomor order
            $table->foreignId('user_id')->constrained('users'); // ID user yang membuat order
            $table->foreignId('courier_id')->nullable()->constrained('users'); // kurir yang mengantarkan order, bisa null jika belum ditugaskan
            $table->foreignId('address_id')->constrained('customer_addresses'); // ID alamat pengiriman
            $table->date('delivery_date')->nullable(); //tanggal pesanan ingin sampai ke pelanggan
            $table->time('delivery_time')->nullable(); //waktu pesanan ingin sampai ke pelanggan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->decimal('total_price', 10, 2); // Total harga order
            $table->string('payment_method')->default('transfer'); // Metode pembayaran
            $table->string('payment_proof')->nullable(); // Bukti pembayaran
            $table->string('payment_status')->default('Validasi pembayaran'); // Status pembayaran
            $table->enum('order_status', ['menunggu konfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu konfirmasi'); // Status order
            $table->timestamp('order_at')->nullable(); // Waktu order dibuat
            $table->timestamp('processed_at')->nullable(); // Waktu order diproses
            $table->timestamp('sent_at')->nullable(); // Waktu order dikirim
            $table->timestamp('arrived_at')->nullable(); // Waktu order tiba
            $table->string('arrival_proof')->nullable(); // Bukti pesanan sampai ke pelanggan
            $table->timestamp('completed_at')->nullable(); // Waktu order selesai
            $table->timestamp('canceled_at')->nullable(); // Waktu order dibatalkan
            $table->text('cancellation_reason')->nullable(); // Alasan pembatalan
            $table->foreignId('canceled_by')->nullable()->constrained('users'); // ID user yang membatalkan
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
