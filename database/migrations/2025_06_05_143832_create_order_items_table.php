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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('order_item_id');
            $table->string('order_number', 50); // Kolom foreign key ke orders.order_number
            $table->foreignId('menu_id')->constrained('menus', 'menu_id')->onDelete('cascade'); // ID menu yang terkait dengan item ini
            $table->decimal('price', 38, 2); // Harga per item
            $table->integer('quantity')->default(1); // Jumlah item yang dipesan
            $table->text('notes')->nullable(); // Catatan tambahan untuk item, bisa null
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            $table->foreign('order_number')->references('order_number')->on('orders')->onDelete('cascade');
            $table->index('order_number'); // Index untuk order_number untuk performa query
            $table->index('menu_id'); // Index untuk menu_id untuk performa query
            $table->index('created_at'); // Index untuk created_at untuk performa query
            $table->index('updated_at'); // Index untuk updated_at untuk performa query
            $table->index('deleted_at'); // Index untuk deleted_at untuk performa query pada soft deletes
            $table->unique(['order_number', 'menu_id'], 'unique_order_item'); // Unik kombinasi order_number dan menu_id untuk mencegah duplikasi item dalam order
            $table->comment('Tabel ini menyimpan informasi item yang dipesan dalam setiap order. Setiap item terkait dengan nomor order dan menu tertentu, dengan jumlah, harga per item, dan catatan tambahan. Total harga dihitung secara dinamis berdasarkan jumlah dan harga per item.'); // Deskripsi tabel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
