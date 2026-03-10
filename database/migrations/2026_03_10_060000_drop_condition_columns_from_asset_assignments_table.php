<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->dropColumn(['condition_on_assign', 'condition_on_return']);
        });
    }

    public function down(): void
    {
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->enum('condition_on_assign', ['new', 'good', 'fair', 'poor'])->default('good')->after('expected_return_date');
            $table->enum('condition_on_return', ['new', 'good', 'fair', 'poor', 'damaged', 'lost'])->nullable()->after('condition_on_assign');
        });
    }
};
