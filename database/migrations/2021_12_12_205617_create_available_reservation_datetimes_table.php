<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableReservationDatetimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_reservation_datetimes', function (Blueprint $table) {
            $table->id();
            $table->date('available_date')->comment('利用可能日');
            $table->time('available_time')->comment('利用可能時間');
            $table->integer('fee_id')->nullable()->comment('料金ID');
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
        Schema::dropIfExists('available_reservation_datetimes');
    }
}
