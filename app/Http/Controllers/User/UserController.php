<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Validator;

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
    public function register(UserFormRequest $request)
    {
        $userParams = [
            'name' => $request->parentName,
            'name_kana' => $request->parentNameKana,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'post_code' => $request->postCode,
            'address' => $request->address,
        ];

        if ($request->has('introduction')) {
            $userParams['introduction'] = $request->introduction;
        }

        if ($request->has('consultation')) {
            $userParams['consultation'] = $request->consultation;
        }

        if ($request->has('lineConsultation') && $request->lineConsultation) {
            $userParams['line_consultation'] = true;
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

        $childParams = [
            'name' => $request->childName,
            'name_kana' => $request->childNameKana,
            'age' => $request->age,
            'gender' => $request->gender,
            'diagnosis' => $request->diagnosis,
        ];

        // 子どもの情報も保存（ここでは子どもモデルが別にあると仮定）
        $user->children()->create([
            'name' => $request->childName,
            'name_kana' => $request->childNameKana,
            'age' => $request->age,
            'gender' => $request->gender,
            'diagnosis' => $request->diagnosis,
        ]);

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
