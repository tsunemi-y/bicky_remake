<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('利用児氏名');
            $table->integer('age')->nullable()->comment('年齢');
            $table->string('gender')->nullable()->comment('性別');
            $table->string('email')->nullable()->comment('メルアド');
            $table->string('diagnosis')->nullable()->comment('診断名');
            $table->string('address')->nullable()->comment('住所');
            $table->string('introduction')->nullable()->comment('紹介先');
            $table->date('reservation_date')->nullable()->comment('予約日');
            $table->time('reservation_time')->nullable()->comment('予約時間');
            $table->string('cancel_code')->nullable()->comment('キャンセルコード');
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
        Schema::dropIfExists('reservations');
    }
}
