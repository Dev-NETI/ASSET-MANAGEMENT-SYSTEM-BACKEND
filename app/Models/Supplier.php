<?php

namespace App\Models;

use App\Traits\HasModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasModifiedBy;
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'department_id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function stockReceivials(): HasMany
    {
        return $this->hasMany(StockReceival::class);
    }
}
