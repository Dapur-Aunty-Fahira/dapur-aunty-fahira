<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PostgreSQL-compatible ALTER TABLE untuk mengubah panjang kolom
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_method TYPE VARCHAR(20);");
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status TYPE VARCHAR(20);");
        DB::statement("ALTER TABLE orders ALTER COLUMN arrival_proof TYPE VARCHAR(100);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_method TYPE VARCHAR(255);");
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status TYPE VARCHAR(255);");
        DB::statement("ALTER TABLE orders ALTER COLUMN arrival_proof TYPE VARCHAR(255);"); // jika sebelumnya tetap 255
    }
};
