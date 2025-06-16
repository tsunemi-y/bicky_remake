<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveChildColumnsFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'childName',
                'childName2',
                'age',
                'gender',
                'diagnosis',
                'age2',
                'gender2',
                'diagnosis2',
                'child_name2_kana',
                'coursePlan',
                'use_time',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('childName');
            $table->string('childName2')->nullable();
            $table->integer('age2')->nullable();
            $table->string('gender2')->nullable();
            $table->string('diagnosis2')->nullable();
            $table->string('child_name2_kana')->nullable();
        });
    }
}