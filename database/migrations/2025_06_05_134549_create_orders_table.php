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
            $table->string('order_number', 50); // Nomor order
            $table->primary('order_number'); // Set order_number as primary key
            $table->integer('user_id')->unsigned(); // ID user yang membuat order
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // Foreign key ke users.user_id
            $table->integer('courier_id')->unsigned()->nullable(); // kurir yang mengantarkan order, bisa null jika belum ditugaskan
            $table->foreign('courier_id')->references('user_id')->on('users')->onDelete('set null'); // Foreign key ke users.user_id
            $table->text('address');
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
            $table->foreignId('canceled_by')->nullable()->constrained('users', 'user_id'); // ID user yang membatalkan
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            $table->index('user_id'); // Index untuk user_id untuk performa query
            $table->index('courier_id'); // Index untuk courier_id untuk performa query
            $table->index('address'); // Index untuk address_id untuk performa query
            $table->index('order_status'); // Index untuk order_status untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
            $table->index('updated_at'); // Index untuk updated_at untuk performa query
            $table->index('deleted_at'); // Index untuk deleted_at untuk performa query pada soft deletes
            $table->comment('Tabel ini menyimpan informasi order yang dibuat oleh user. Setiap order terkait dengan user, kurir, alamat pengiriman, dan memiliki status serta waktu yang berbeda. Order juga dapat memiliki catatan tambahan, total harga, metode pembayaran, dan bukti pembayaran. Status order mencakup berbagai tahap dari menunggu konfirmasi hingga selesai atau dibatalkan.'); // Deskripsi tabel
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
