<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'department_id',
        'position',
        'email',
        'phone',
        'status',
    ];

    protected $appends = ['full_name'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assetAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable');
    }

    public function activeAssetAssignments(): MorphMany
    {
        return $this->morphMany(AssetAssignment::class, 'assignable')->where('status', 'active');
    }

    public function stockIssuances(): MorphMany
    {
        return $this->morphMany(StockIssuance::class, 'issuable');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
