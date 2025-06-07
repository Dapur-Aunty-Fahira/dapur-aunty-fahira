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
        Schema::create('menus', function (Blueprint $table) {
            $table->id('menu_id'); // ID menu
            $table->foreignId('category_id')->constrained('categories'); // ID kategori menu
            $table->string('name'); // Nama menu
            $table->string('image')->nullable(); // Gambar menu, bisa null
            $table->text('description')->nullable(); // Deskripsi menu, bisa null
            $table->decimal('price', 10, 2); // Harga menu
            $table->integer('min_order')->default(1); // Jumlah minimum pemesanan
            $table->boolean('is_available')->default(true); // Status ketersediaan menu
            $table->boolean('is_popular')->default(false); // Status menu populer
            $table->boolean('is_new')->default(false); // Status menu baru
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
