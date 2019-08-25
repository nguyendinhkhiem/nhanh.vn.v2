<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhanhvn')->nullable();
            $table->string('handoverId')->nullable();
            $table->string('privateId')->nullable();
            $table->string('depotId')->nullable();
            $table->string('channel')->nullable();
            $table->string('depotName')->nullable();
            $table->string('type')->nullable();
            $table->string('typeId')->nullable();
            $table->string('shippingType')->nullable();
            $table->string('shippingTypeId')->nullable();
            $table->integer('moneyDiscount')->nullable();
            $table->integer('moneyDeposit')->nullable();
            $table->integer('moneyTransfer')->nullable();
            $table->string('carrierId')->nullable();
            $table->string('carrierName')->nullable();
            $table->string('serviceId')->nullable();
            $table->string('serviceName')->nullable();
            $table->string('carrierCode')->nullable();
            $table->string('shipFee')->nullable();
            $table->string('codFee')->nullable();
            $table->string('customerShipFee')->nullable();
            $table->string('returnFee')->nullable();
            $table->string('overWeightShipFee')->nullable();
            $table->string('description')->nullable();
            $table->string('privateDescription')->nullable();
            $table->string('customerId')->nullable();
            $table->string('customerName')->nullable();
            $table->string('customerEmail')->nullable();
            $table->string('customerMobile')->nullable();
            $table->string('customerAddress')->nullable();
            $table->string('shipToCityLocationId')->nullable();
            $table->string('customerCity')->nullable();
            $table->string('shipToDistrictLocationId')->nullable();
            $table->string('customerDistrict')->nullable();
            $table->string('createdById')->nullable();
            $table->string('createdByUserName')->nullable();
            $table->string('createdByName')->nullable();
            $table->string('saleId')->nullable();
            $table->string('saleName')->nullable();
            $table->string('createdDateTime')->nullable();
            $table->string('deliveryDate')->nullable();
            $table->string('statusName')->nullable();
            $table->string('statusCode')->nullable();
            $table->integer('calcTotalMoney')->nullable();
            $table->string('trafficSourceId')->nullable();
            $table->string('trafficSourceName')->nullable();
            $table->text('products')->nullable();
            $table->string('status')->nullable();
            $table->string('statusGHTK')->nullable();
            $table->string('statusGHTK_name')->nullable();
            $table->string('label_GHTK')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
