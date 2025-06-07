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
            $table->id(); // ID unik untuk setiap item order
            $table->string('order_number', 50); // Kolom foreign key ke orders.order_number
            $table->foreign('order_number')->references('order_number')->on('orders')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // ID menu yang dipesan
            $table->integer('quantity')->default(1); // Jumlah item yang dipesan
            $table->decimal('price', 10, 2); // Harga per item
            $table->decimal('total_price', 10, 2); // Total harga untuk item ini, dihitung sebagai quantity * price
            $table->text('notes')->nullable(); // Additional notes for this item, can be null
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
            $table->softDeletes(); // Kolom untuk soft delete
            // Ensure total_price is calculated dynamically in queries and not stored in the database
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
