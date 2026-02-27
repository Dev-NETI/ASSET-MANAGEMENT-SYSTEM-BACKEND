<?php

namespace App\Models;

use App\Traits\HasModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryStock extends Model
{
    use HasModifiedBy;
    protected $fillable = [
        'item_id',
        'department_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    protected $appends = ['is_below_minimum'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getIsBelowMinimumAttribute(): bool
    {
        return $this->item && $this->item->min_stock_level > 0
            && $this->quantity < $this->item->min_stock_level;
    }

    public function isBelowMinimum(): bool
    {
        return $this->getIsBelowMinimumAttribute();
    }
}
