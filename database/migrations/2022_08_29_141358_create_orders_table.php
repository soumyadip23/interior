<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('unique_id');
            $table->integer('restaurant_id');
            $table->integer('user_id');
            $table->integer('delivery_boy_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('delivery_address');
            $table->string('delivery_landmark');
            $table->string('delivery_country');
            $table->string('delivery_city');
            $table->string('delivery_pin');
            $table->double('delivery_lat', 15, 8);
            $table->double('delivery_lng', 15, 8);
            $table->double('amount');
            $table->string('coupon_code');
            $table->double('discounted_amount');
            $table->double('delivery_charge');
            $table->double('packing_price');
            $table->double('tax_amount');
            $table->double('total_amount');
            $table->integer('status')->default(1)->comment('1=new,2=accepted,3=delivery boy assigned,4=order on process,5=rider started towards restaurants, 6=reached restaurant,7=order picked,8=delivered,9=collect money,10=cancelled');
            $table->integer('preparation_time');
            $table->text('cancellation_reason');
            $table->string('transaction_id');
            $table->integer('payment_status')->default(0)->comment('1=paid');
            $table->integer('is_deleted')->default(0);
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
