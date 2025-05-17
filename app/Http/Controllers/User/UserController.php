<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function response;
use function auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Services\UserService;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\LoginFormRequest;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * ユーザーログイン処理
     *
     * @param  \App\Http\Requests\LoginFormRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginFormRequest $request)
    {
        // JWT認証を試みる
        if (!$token = auth('api')->attempt($request->only(['email', 'password']))) {
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
    public function store(Request $request)
    {
        $userParams = [
            'name' => $request->parentName,
            'name_kana' => $request->parentNameKana,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'post_code' => $request->postCode,
            'address' => $request->address,
            'introduction' => $request->introduction,
        ];

        $user = $this->userService->createUser($userParams);
        Log::info($user);

        // ====ループして登録====
        if (is_array($request->children)) {
            foreach ($request->children as $child) {
                $childParams = [
                    'user_id'           => $user->id,
                    'name'              => $child['childName'] ?? null,
                    'name_kana'         => $child['childNameKana'] ?? null,
                    'birth_date'        => $child['childBirthDate'] ?? null,
                    'gender'            => $child['gender'] ?? null,
                    'diagnosis'         => $child['diagnosis'] ?? null,
                    'has_questionnaire' => 0,
                ];
                $this->userService->createChild($childParams);
            }
        }
        // ====ループして登録====

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
