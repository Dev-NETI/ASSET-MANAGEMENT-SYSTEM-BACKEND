<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Normalize any legacy 'lost' status before narrowing the enum
        DB::statement("UPDATE asset_assignments SET status = 'returned' WHERE status = 'lost'");

        DB::statement("ALTER TABLE asset_assignments MODIFY COLUMN status ENUM('active', 'returned') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE asset_assignments MODIFY COLUMN status ENUM('active', 'returned', 'lost') NOT NULL DEFAULT 'active'");
    }
};
