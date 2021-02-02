<?php

namespace App\Traits;

trait IsOrderable
{
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }
}
