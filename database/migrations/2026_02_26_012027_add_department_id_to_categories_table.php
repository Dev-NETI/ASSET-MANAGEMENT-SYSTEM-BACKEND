<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('department_id')
                  ->nullable()
                  ->after('parent_id')
                  ->constrained()
                  ->nullOnDelete();
            // Drop the old global unique index on code
            $table->dropUnique(['code']);
            // Add composite unique so same code can exist per department
            $table->unique(['code', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['code', 'department_id']);
            $table->unique('code');
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};
