<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_issuances', function (Blueprint $table) {
            $table->string('issuable_type')->nullable()->change();
        });

        // Convert any previously stored 'others' string to null
        DB::table('stock_issuances')
            ->where('issuable_type', 'others')
            ->update(['issuable_type' => null]);
    }

    public function down(): void
    {
        DB::table('stock_issuances')
            ->whereNull('issuable_type')
            ->update(['issuable_type' => 'others']);

        Schema::table('stock_issuances', function (Blueprint $table) {
            $table->string('issuable_type')->nullable(false)->change();
        });
    }
};
