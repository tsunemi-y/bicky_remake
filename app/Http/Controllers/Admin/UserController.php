<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\MailService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * ユーザ一覧取得
     * @param Illuminate\Http\Request
     * @return App\Models\User
     */
    public function getUsers(Request $request)
    {
        $userModel = new User();
        $users = $userModel
            ->fuzzyName($request->name)
            ->equalId($request->id)
            ->get(['id', 'parentName', 'email']);
        return $users;
    }

    /**
     * 評価表送信
     * @param Illuminate\Http\Request
     * @return App\Models\User
     */
    public function sendEvaluation(Request $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('', $fileName);

        // パラメータ設定
        $args = [
            "name"  => $request->name,
            "email" => $request->email,
        ];

        $attachFile = "app/{$fileName}";

        // メールデータ作成
        $viewFile = 'admin.emails.evaluation';
        $subject = '評価表のご送付';

        // 評価表送信
        $mailService = new MailService();
        $mailService->sendMailToUser($args, $viewFile, $subject, $attachFile);

        // 評価表削除
        unlink(storage_path("app/{$fileName}"));
    }
}
