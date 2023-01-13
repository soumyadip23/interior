<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->string('customer_lat');
            $table->string('customer_long');
            $table->text('requirement');
            $table->string('source');
            $table->text('remarks');
            $table->double('budget');
            $table->integer('created_by');
            $table->integer('assigned_to');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('leads');
    }
}
