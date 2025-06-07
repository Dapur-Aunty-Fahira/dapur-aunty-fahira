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
            $table->id(); // as the primary key
            $table->string('name')->unique(); // Unique name for the category
            $table->text('description')->nullable(); // Optional description for the category
            $table->boolean('is_active')->default(true); // Status to indicate if the category is active
            $table->timestamps();
            $table->softDeletes(); // Soft delete field to allow for category restoration
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
