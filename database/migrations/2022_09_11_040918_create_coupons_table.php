<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->string('code');
            $table->integer('type')->comment('1=percentage,2=flat');
            $table->integer('rate');
            $table->integer('maximum_offer_rate');
            $table->date('start_date')->default(NULL);
            $table->date('end_date')->default(NULL);
            $table->integer('maximum_time_of_use')->comment('how many times this coupon can be used');
            $table->integer('maximum_time_user_can_use')->comment('how many times an user can use this coupon');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('coupons');
    }
}
