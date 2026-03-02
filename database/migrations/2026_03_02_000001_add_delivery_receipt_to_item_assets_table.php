<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_assets', function (Blueprint $table) {
            $table->string('delivery_receipt_no')->nullable()->after('notes');
            $table->string('delivery_receipt_file')->nullable()->after('delivery_receipt_no');
        });
    }

    public function down(): void
    {
        Schema::table('item_assets', function (Blueprint $table) {
            $table->dropColumn(['delivery_receipt_no', 'delivery_receipt_file']);
        });
    }
};
