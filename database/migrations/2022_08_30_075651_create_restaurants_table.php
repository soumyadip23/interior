<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->string('image');
            $table->text('description');
            $table->string('address');
            $table->string('location');
            $table->double('lat', 15, 8);
            $table->double('lng', 15, 8);
            $table->string('start_time');
            $table->string('close_time');
            $table->integer('is_pure_veg')->default(0)->comment('1 = pure veg');
            $table->double('commission_rate', 5, 2);
            $table->integer('estimated_delivery_time')->comment('time in minutes');
            $table->integer('is_not_taking_orders')->default(0)->comment('1 = not taking orders');
            $table->integer('status')->default(1);
            $table->integer('is_trending')->default(0);
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
        Schema::dropIfExists('restaurants');
    }
}
