<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->company_id = auth()->user()->company_id;
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('company_id', auth()->user()->company_id);
            }
        });
    }
}
