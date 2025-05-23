<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_reservation', function (Blueprint $table) {
            // child_id を外部キーとして設定
            $table->foreignId('child_id')
                  ->constrained('children')
                  ->onDelete('cascade');

            // reservation_id を外部キーとして設定
            $table->foreignId('reservation_id')
                  ->constrained('reservations')
                  ->onDelete('cascade');

            // 重複登録を防ぐため複合主キーにする
            $table->primary(['child_id', 'reservation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_reservation');
    }
} 