<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryBoysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_boys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->string('image');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('pin');
            $table->integer('vehicle_type');
            $table->string('gender');
            $table->date('date_of_birth')->default(NULL);
            $table->integer('status')->default(0);
            $table->integer('is_deleted')->default(0);
            $table->text('remember_token')->nullable();
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
        Schema::dropIfExists('delivery_boys');
    }
}
