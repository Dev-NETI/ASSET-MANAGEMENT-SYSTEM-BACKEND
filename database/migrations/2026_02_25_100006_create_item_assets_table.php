<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Each row = one physical unit of a fixed_asset item
        Schema::create('item_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            // Unique item code per physical unit, e.g. NOD-LAP-001
            $table->string('item_code')->unique();
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->enum('condition', ['new', 'good', 'fair', 'poor', 'damaged', 'lost', 'disposed'])->default('new');
            // Which department currently holds/owns this asset
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->enum('status', ['available', 'assigned', 'under_repair', 'disposed'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_assets');
    }
};
