<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('子ども氏名');
            $table->string('name_kana')->comment('子ども氏名（カナ）');
            $table->date('birth_date')->comment('生年月日');
            $table->string('gender')->comment('性別');
            $table->text('symptoms')->nullable()->comment('症状');
            $table->boolean('has_questionnaire')->default(false)->comment('問診票記入済みフラグ');
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
        Schema::dropIfExists('children');
    }
} 