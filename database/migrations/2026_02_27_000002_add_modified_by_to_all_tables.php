<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'departments',
        'categories',
        'units',
        'suppliers',
        'items',
        'employees',
        'item_assets',
        'inventory_stocks',
        'asset_assignments',
        'stock_issuances',
        'stock_receivals',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->string('modified_by')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('modified_by');
            });
        }
    }
};
