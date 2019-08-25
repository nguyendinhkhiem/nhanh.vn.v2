<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner.
 *
 * @package namespace App\Entities;
 */
class Deliverys extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'partner_id',
        'label',
        'area',
        'fee',
        'insurance_fee',
        'estimated_pick_time',
        'estimated_deliver_time',
        'nhanh_order_id',
        'products',
        'tracking_id',
        'sorting_code',
        'status_id',
    ];
}
