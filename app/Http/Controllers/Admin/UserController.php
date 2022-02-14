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
        \Debugbar::info($request);
        $userModel = new User();
        $users = $userModel
            ->fuzzyName($request->name)
            ->equalId($request->id)
            ->get(['id', 'parentName', 'email', 'fee']);
        return $users;
    }

    /**
     * 領収書送信 todo：　共通化　評価表も送るため pdfじゃないと送れないようにバリで
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function sendReceipt(Request $request)
    {
        // パラメータ設定
        $args = [
            "name"              => $request->name,
            "email"             => $request->email,
            "fee"               => $request->fee,
        ];

        // メールデータ作成
        $date = date('Ymd');
        $viewFile = 'admin.emails.receipt';
        $subject = '領収書のご送付';
        $attachFile = "app/領収書_{$date}.pdf";

        // 領収書を出力し、ストレージに配置
        $pdf = \PDF::loadView('admin/emails/receiptPdf', $args);
        $downloadedPdf = $pdf->output();
        file_put_contents(storage_path("app/領収書_{$date}.pdf"), $downloadedPdf);

        // 領収書送信
        $mailService = new MailService();
        $mailService->sendMailToUser($args, $viewFile, $subject, $attachFile);

        // 領収書削除
        unlink(storage_path("app/領収書_{$date}.pdf"));
    }

    /**
     * 料金更新 todo: バリデ
     * @param Illuminate\Http\Request
     * @param App\Models\User
     * 
     * @return void
     */
    public function updateFee(Request $request, User $user)
    {
        $user->update([
            'fee' => $request->fee,
        ]);
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
