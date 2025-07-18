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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id'); // ID kategori, auto-increment sebagai primary key
            $table->string('name', 100)->unique(); // Unique name for the category
            $table->text('description')->nullable(); // Optional description for the category
            $table->boolean('is_active')->default(true); // Status to indicate if the category is active
            $table->timestamps();
            $table->softDeletes(); // Soft delete field to allow for category restoration
            $table->index('name'); // Index for name for query performance
            $table->index('created_at'); // Index for created_at for query performance
            $table->index('updated_at'); // Index for updated_at for query performance
            $table->index('deleted_at'); // Index for deleted_at for query performance on soft deletes
            $table->comment('Tabel ini menyimpan informasi kategori yang tersedia di aplikasi. Setiap kategori memiliki nama unik, deskripsi opsional, dan status aktif. Kategori dapat digunakan untuk mengelompokkan menu yang ada.'); // Deskripsi tabel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
