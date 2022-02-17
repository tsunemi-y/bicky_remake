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
            $table->string('tel');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // 追加　start
            $table->string('childName')->comment('利用児氏名');
            $table->integer('age')->comment('年齢');
            $table->string('gender')->comment('性別');
            $table->string('diagnosis')->nullable()->comment('診断名');
            $table->string('childName2')->nullable()->comment('利用児氏名2');
            $table->integer('age2')->nullable()->comment('年齢2');
            $table->string('gender2')->nullable()->comment('性別2');
            $table->string('diagnosis2')->nullable()->comment('診断2');
            $table->string('address')->comment('住所');
            $table->string('introduction')->nullable()->comment('紹介先');
            $table->integer('coursePlan')->comment('コースプラン');
            $table->string('consaltation')->nullable()->comment('相談内容');
            $table->string('fee')->nullable()->comment('料金');
            $table->string('userAgent')->nullable()->comment('ユーザエージェント');
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
