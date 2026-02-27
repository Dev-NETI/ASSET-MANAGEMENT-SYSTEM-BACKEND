<?php

namespace App\Models;

use App\Traits\HasModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Department extends Model
{
    use HasModifiedBy;
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function itemAssets(): HasMany
    {
        return $this->hasMany(ItemAsset::class);
    }

    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class);
    }

    public function assetAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable');
    }

    public function stockIssuancesReceived(): MorphMany
    {
        return $this->morphMany(StockIssuance::class, 'issuable');
    }

    public function stockReceivalsReceived(): HasMany
    {
        return $this->hasMany(StockReceival::class);
    }
}
