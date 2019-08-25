<?php

namespace App\Entities;

use App\Entities\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner.
 *
 * @package namespace App\Entities;
 */
class Order extends Model
{

    const STATUS_NEW_CREATEED = 0; //mới clone của nhanh.vn.
	const STATUS_OLD = 1; //database hệ thống đã có.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_nhanhvn',
        'handoverId',
        'privateId',
        'depotId',
        'channel',
        'depotName',
        'type',
        'typeId',
        'shippingType',
        'shippingTypeId',
        'moneyDiscount',
        'moneyDeposit',
        'moneyTransfer',
        'carrierId',
        'carrierName',
        'serviceId',
        'serviceName',
        'carrierCode',
        'shipFee',
        'codFee',
        'customerShipFee',
        'returnFee',
        'overWeightShipFee',
        'description',
        'privateDescription',
        'customerId',
        'customerName',
        'customerEmail',
        'customerMobile',
        'customerAddress',
        'shipToCityLocationId',
        'customerCity',
        'shipToDistrictLocationId',
        'customerDistrict',
        'createdById',
        'createdByUserName',
        'createdByName',
        'saleId',
        'saleName',
        'createdDateTime',
        'deliveryDate',
        'statusName',
        'statusCode',
        'calcTotalMoney',
        'trafficSourceId',
        'trafficSourceName',
        'products',
        'status',
        'statusGHTK',
        'statusGHTK_name',
        'label_GHTK'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
