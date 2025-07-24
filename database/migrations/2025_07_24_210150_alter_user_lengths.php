<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah panjang kolom
        DB::statement("ALTER TABLE users ALTER COLUMN name TYPE VARCHAR(50);");
        DB::statement("ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(50);");
        DB::statement("ALTER TABLE users ALTER COLUMN password TYPE VARCHAR(50);");
        DB::statement("ALTER TABLE users ALTER COLUMN remember_token TYPE VARCHAR(50);");

        // Ganti enum role menjadi VARCHAR(10)
        DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(10) USING role::VARCHAR(10);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke panjang semula
        DB::statement("ALTER TABLE users ALTER COLUMN name TYPE VARCHAR(100);");
        DB::statement("ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(100);");
        DB::statement("ALTER TABLE users ALTER COLUMN password TYPE VARCHAR(100);");
        DB::statement("ALTER TABLE users ALTER COLUMN remember_token TYPE VARCHAR(100);");

        // Kembalikan kolom role ke enum
        // Harus buat tipe enum baru
        DB::statement("CREATE TYPE user_role_enum AS ENUM ('admin', 'pelanggan', 'kurir');");
        DB::statement("ALTER TABLE users ALTER COLUMN role TYPE user_role_enum USING role::user_role_enum;");
    }
};
