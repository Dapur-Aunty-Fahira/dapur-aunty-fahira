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
            $table->id(); // ID unik untuk setiap keranjang
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID user yang memiliki keranjang
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // ID menu yang ditambahkan ke keranjang
            $table->integer('quantity')->default(1); // Jumlah item menu yang ditambahkan ke keranjang
            $table->decimal('price', 10, 2); // Harga per item menu
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            $table->unique(['user_id', 'menu_id'], 'unique_cart_item'); // Unik kombinasi user_id dan menu_id untuk mencegah duplikasi
            $table->index(['user_id', 'menu_id']); // Index untuk user_id dan menu_id untuk performa query
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
