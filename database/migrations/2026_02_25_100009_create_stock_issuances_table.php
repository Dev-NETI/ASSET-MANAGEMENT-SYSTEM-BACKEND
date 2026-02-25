<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Records each time consumable stock is issued/consumed from a department
        Schema::create('stock_issuances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            // The department whose stock is being drawn from
            $table->foreignId('from_department_id')->constrained('departments')->restrictOnDelete();
            // Polymorphic: issued to an Employee or to a Department
            $table->morphs('issuable');
            $table->decimal('quantity', 12, 2);
            $table->foreignId('issued_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('issued_at');
            $table->string('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_issuances');
    }
};
