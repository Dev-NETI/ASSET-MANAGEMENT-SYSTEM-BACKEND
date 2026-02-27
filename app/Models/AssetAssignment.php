<?php

namespace App\Models;

use App\Traits\HasModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AssetAssignment extends Model
{
    use HasModifiedBy;
    protected $fillable = [
        'asset_id',
        'assignable_type',
        'assignable_id',
        'assigned_by',
        'assigned_at',
        'expected_return_date',
        'returned_at',
        'returned_by',
        'condition_on_assign',
        'condition_on_return',
        'purpose',
        'status',
        'notes',
    ];

    protected $casts = [
        'assigned_at'          => 'datetime',
        'expected_return_date' => 'datetime',
        'returned_at'          => 'datetime',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(ItemAsset::class, 'asset_id');
    }

    /** Resolves to Employee or Department */
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
