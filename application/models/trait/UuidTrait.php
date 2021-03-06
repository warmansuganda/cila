<?php

use Ramsey\Uuid\Uuid;

trait UuidTrait
{

    /**
     * Boot function from laravel.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid1()->toString();
        });
    }
}
