<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_receivals', function (Blueprint $table) {
            $table->renameColumn('reference_no', 'delivery_receipt_no');
            $table->string('delivery_receipt_file')->nullable()->after('delivery_receipt_no');
        });
    }

    public function down(): void
    {
        Schema::table('stock_receivals', function (Blueprint $table) {
            $table->renameColumn('delivery_receipt_no', 'reference_no');
            $table->dropColumn('delivery_receipt_file');
        });
    }
};
