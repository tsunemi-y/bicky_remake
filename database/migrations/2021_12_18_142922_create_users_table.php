<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('parentName')->comment('保護者氏名');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // 追加　start
            $table->string('childName')->nullable()->comment('利用児氏名');
            $table->integer('age')->nullable()->comment('年齢');
            $table->string('gender')->nullable()->comment('性別');
            $table->string('diagnosis')->nullable()->comment('診断名');
            $table->string('address')->nullable()->comment('住所');
            $table->string('introduction')->nullable()->comment('紹介先');
            // 追加　end
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
        Schema::dropIfExists('users');
    }
}
