<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockIssuance extends Model
{
    protected $fillable = [
        'item_id',
        'from_department_id',
        'issuable_type',
        'issuable_id',
        'quantity',
        'issued_by',
        'issued_at',
        'purpose',
        'notes',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'quantity'  => 'decimal:2',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function fromDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    /** Resolves to Employee or Department */
    public function issuable(): MorphTo
    {
        return $this->morphTo();
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
