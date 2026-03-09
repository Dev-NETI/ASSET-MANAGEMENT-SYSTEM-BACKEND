<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->string('assignable_type')->nullable()->change();
            $table->unsignedBigInteger('assignable_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->string('assignable_type')->nullable(false)->change();
            $table->unsignedBigInteger('assignable_id')->nullable(false)->change();
        });
    }
};
