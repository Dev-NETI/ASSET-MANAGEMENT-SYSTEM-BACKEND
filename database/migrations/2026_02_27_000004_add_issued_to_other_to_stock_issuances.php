<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_issuances', function (Blueprint $table) {
            $table->string('issued_to_other')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('stock_issuances', function (Blueprint $table) {
            $table->dropColumn('issued_to_other');
        });
    }
};
