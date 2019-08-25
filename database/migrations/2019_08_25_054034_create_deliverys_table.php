<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label')->nullable();
            $table->string('partner_id')->nullable();
            $table->string('area')->nullable();
            $table->string('fee')->nullable();
            $table->string('insurance_fee')->nullable();
            $table->string('estimated_pick_time')->nullable();
            $table->string('estimated_deliver_time')->nullable();
            $table->text('products')->nullable();
            $table->text('tracking_id')->nullable();
            $table->text('sorting_code')->nullable();
            $table->string('status_id')->nullable();
            $table->text('orders_id')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('deliverys');
    }
}
