<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Normalize any legacy statuses before narrowing the enum
        DB::statement("UPDATE item_assets SET status = 'available' WHERE status IN ('under_repair', 'disposed')");

        DB::statement("ALTER TABLE item_assets MODIFY COLUMN status ENUM('available', 'assigned') NOT NULL DEFAULT 'available'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE item_assets MODIFY COLUMN status ENUM('available', 'assigned', 'under_repair', 'disposed') NOT NULL DEFAULT 'available'");
    }
};
