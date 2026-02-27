<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'unit_id',
        'item_type',
        'brand',
        'model',
        'specifications',
        'min_stock_level',
        'department_id',
    ];

    protected $casts = [
        'specifications' => 'array',
        'min_stock_level' => 'decimal:2',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /** Fixed asset physical units */
    public function assets(): HasMany
    {
        return $this->hasMany(ItemAsset::class);
    }

    /** Consumable stock per department */
    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class);
    }

    public function stockIssuances(): HasMany
    {
        return $this->hasMany(StockIssuance::class);
    }

    public function stockReceivials(): HasMany
    {
        return $this->hasMany(StockReceival::class);
    }

    public function isFixedAsset(): bool
    {
        return $this->item_type === 'fixed_asset';
    }

    public function isConsumable(): bool
    {
        return $this->item_type === 'consumable';
    }
}
