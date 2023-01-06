<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('restaurant_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->double('price');
            $table->double('offer_price');
            $table->integer('is_veg')->default(0)->comment('1 = veg');
            $table->integer('is_cutlery_required')->default(0);
            $table->integer('min_item_for_cutlery');
            $table->integer('in_stock')->default(1)->comment('1= in stock');
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
        Schema::dropIfExists('items');
    }
}
