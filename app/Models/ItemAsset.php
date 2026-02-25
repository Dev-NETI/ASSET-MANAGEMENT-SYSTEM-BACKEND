<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemAsset extends Model
{
    protected $fillable = [
        'item_id',
        'item_code',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'warranty_expiry',
        'condition',
        'department_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date'   => 'date',
        'warranty_expiry' => 'date',
        'purchase_price'  => 'decimal:2',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id');
    }

    public function activeAssignment(): HasOne
    {
        return $this->hasOne(AssetAssignment::class, 'asset_id')->where('status', 'active');
    }
}
