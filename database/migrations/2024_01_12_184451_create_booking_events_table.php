<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oh_id');
            $table->string('name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
            $table->foreign('oh_id')->references('id')->on('opening_hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_events');
    }
};
