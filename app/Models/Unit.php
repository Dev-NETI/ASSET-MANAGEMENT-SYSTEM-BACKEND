<?php

namespace App\Models;

use App\Traits\HasModifiedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasModifiedBy;
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
