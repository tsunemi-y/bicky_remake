<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * お知らせ（タイトル・本文・公開期間など）を管理するテーブルを作成
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // お知らせの見出し
            $table->text('content');               // お知らせの本文
            $table->timestamp('start_at')           // 公開開始日時
                  ->nullable();
            $table->timestamp('end_at')             // 公開終了日時
                  ->nullable();
            $table->boolean('is_active')           // 有効フラグ（公開/非公開）
                  ->default(true);
            $table->timestamps();                  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}