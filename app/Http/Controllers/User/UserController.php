<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ユーザーログイン処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // JWT認証を試みる
        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'メールアドレスまたはパスワードが正しくありません'], 401);
        }

        // トークンを含むレスポンスを返す
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

    /**
     * 新規ユーザー登録処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parentName' => 'required|string|max:255',
            'parentNameKana' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'tel' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'childName' => 'required|string|max:255',
            'childNameKana' => 'required|string|max:255',
            'age' => 'required|numeric',
            'gender' => 'required|string|in:男の子,女の子',
            'postCode' => 'required|string|max:8',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ユーザー作成
        $user = User::create([
            'name' => $request->parentName,
            'name_kana' => $request->parentNameKana,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'post_code' => $request->postCode,
            'address' => $request->address,
        ]);

        // 子どもの情報も保存（ここでは子どもモデルが別にあると仮定）
        $user->children()->create([
            'name' => $request->childName,
            'name_kana' => $request->childNameKana,
            'age' => $request->age,
            'gender' => $request->gender,
            'diagnosis' => $request->diagnosis,
        ]);

        // オプションの追加情報があれば保存
        if ($request->has('introduction')) {
            $user->update(['introduction' => $request->introduction]);
        }

        if ($request->has('consultation')) {
            $user->update(['consultation' => $request->consultation]);
        }

        if ($request->has('lineConsultation') && $request->lineConsultation) {
            $user->update(['line_consultation' => true]);
        }

        // 登録後すぐにJWTトークンを生成してログイン状態にする
        $token = auth('api')->login($user);

        return response()->json([
            'message' => '登録が完了しました',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ], 201);
    }
}
