<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lead_id');
            $table->text('client_comment');
            $table->text('staff_comment');
            $table->date('next_follow_date');
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
        Schema::dropIfExists('lead_feedbacks');
    }
}
