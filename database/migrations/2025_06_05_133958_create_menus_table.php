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
            $table->increments('menu_id'); // ID menu, auto-increment sebagai primary key
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade'); // Foreign key ke categories.category_id
            $table->string('name', 100); // Nama menu
            $table->string('image', 255)->nullable(); // Gambar menu, bisa null
            $table->text('description')->nullable(); // Deskripsi menu, bisa null
            $table->decimal('price', 38, 2); // Harga menu
            $table->integer('min_order')->default(1); // Jumlah minimum pemesanan
            $table->boolean('is_available')->default(true); // Status ketersediaan menu
            $table->boolean('is_popular')->default(false); // Status menu populer
            $table->boolean('is_new')->default(false); // Status menu baru
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            $table->unique('name'); // Unik nama menu untuk mencegah duplikasi
            $table->index('category_id'); // Index untuk category_id untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
            $table->index('updated_at'); // Index untuk updated_at untuk performa query
            $table->index('deleted_at'); // Index untuk deleted_at untuk performa query pada soft deletes
            $table->comment('Tabel ini menyimpan informasi menu yang tersedia di aplikasi. Setiap menu terkait dengan kategori tertentu, memiliki nama, gambar, deskripsi, harga, dan status ketersediaan. Menu juga dapat ditandai sebagai populer atau baru.'); // Deskripsi tabel
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
