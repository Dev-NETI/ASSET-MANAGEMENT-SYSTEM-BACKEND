<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE categories DROP INDEX categories_code_department_id_unique');
        DB::statement('ALTER TABLE categories DROP COLUMN code');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE categories ADD COLUMN code VARCHAR(20) NULL UNIQUE AFTER name');
    }
};
