<?php
namespace App\Entities;

use App\Entities\Order;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'productId',
        'productName',
        'productCode',
        'productBarCode',
        'price',
        'quantity',
        'weight',
        'discount',
        'description',
        'imei'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}