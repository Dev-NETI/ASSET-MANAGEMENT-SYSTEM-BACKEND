<?php

namespace App\Traits;

trait HasModifiedBy
{
    protected static function bootHasModifiedBy(): void
    {
        static::saving(function ($model) {
            if (auth()->check()) {
                $model->modified_by = auth()->user()->name;
            }
        });
    }
}
