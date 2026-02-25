<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tracks every assignment of a fixed-asset unit to a person or department
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('item_assets')->restrictOnDelete();
            // Polymorphic: assignable can be an Employee or a Department
            $table->morphs('assignable');
            $table->foreignId('assigned_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('assigned_at');
            $table->timestamp('expected_return_date')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->foreignId('returned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('condition_on_assign', ['new', 'good', 'fair', 'poor'])->default('good');
            $table->enum('condition_on_return', ['new', 'good', 'fair', 'poor', 'damaged', 'lost'])->nullable();
            $table->string('purpose')->nullable();
            $table->enum('status', ['active', 'returned', 'lost'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
