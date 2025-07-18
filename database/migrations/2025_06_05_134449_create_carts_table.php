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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('cart_id'); // ID unik untuk setiap keranjang
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // ID user yang memiliki keranjang
            $table->foreignId('menu_id')->constrained('menus', 'menu_id')->onDelete('cascade'); // ID menu yang ditambahkan ke keranjang
            $table->integer('quantity')->default(1); // Jumlah item menu yang ditambahkan ke keranjang
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            $table->unique(['user_id', 'menu_id'], 'unique_cart_item'); // Unik kombinasi user_id dan menu_id untuk mencegah duplikasi
            $table->index(['user_id', 'menu_id']); // Index untuk user_id dan menu_id untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
            $table->index('updated_at'); // Index untuk updated_at untuk performa query
            $table->index('deleted_at'); // Index untuk deleted_at untuk performa query pada soft deletes
            $table->comment('Tabel ini menyimpan informasi keranjang belanja untuk setiap user. Setiap item keranjang terkait dengan user dan menu tertentu, dengan jumlah dan harga yang ditentukan. Total harga dihitung secara dinamis berdasarkan jumlah dan harga per item.'); // Deskripsi tabel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
