<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'content',
    ];
}
