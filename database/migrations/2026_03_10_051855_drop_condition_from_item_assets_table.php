<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_assets', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
    }

    public function down(): void
    {
        Schema::table('item_assets', function (Blueprint $table) {
            $table->enum('condition', ['new', 'good', 'fair', 'poor', 'damaged', 'lost', 'disposed'])->default('new')->after('warranty_expiry');
        });
    }
};
