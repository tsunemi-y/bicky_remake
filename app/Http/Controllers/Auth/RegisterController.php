<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\AlphaNumHalf;
use App\Consts\User as constUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\LineMessengerController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'parentName'   => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', new AlphaNumHalf, 'min:8', 'confirmed'],
            'childName'    => ['required', 'string', 'max:255'],
            'age'          => ['required', 'integer'],
            'gender'       => ['required', 'string'],
            'diagnosis'    => ['nullable', 'string', 'max:255'],
            'childName2'   => ['nullable', 'string', 'max:255'],
            'age2'         => ['nullable', 'integer'],
            'gender2'      => ['nullable', 'string', 'max:255'],
            'diagnosis2'    => ['nullable', 'string', 'max:255'],
            'address'      => ['required', 'string', 'max:255'],
            'coursePlan'   => ['required', 'integer'],
            'introduction' => ['nullable', 'string', 'max:255'],
            'consaltation' => ['nullable', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Array  $data
     * @return App\Models\User
     */
    protected function create(array $data)
    {
        $this->validator($data);

        $coursePlan = $this->getFeeByCourse((int) $data['numberOfUse'], (int) $data['coursePlan'], $data['childName2']);

        $user = User::create([
            'parentName'   => $data['parentName'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'childName'    => $data['childName'],
            'age'          => $data['age'],
            'gender'       => $data['gender'],
            'diagnosis'    => $data['diagnosis'],
            'childName2'   => $data['childName2'],
            'age2'         => $data['age2'],
            'gender2'      => $data['gender2'],
            'diagnosis2'   => $data['diagnosis2'],
            'address'      => $data['address'],
            'introduction' => $data['introduction'],
            'coursePlan'   => $data['coursePlan'],
            'consaltation' => $data['consaltation'],
            'fee' => $coursePlan,
        ]);

        $lineModel = new LineMessengerController();
        $lineModel->sendRegistrationMessage($user);

        return $user;
    }

    /**
     * 選択されたコースの条件によって料金取得
     * @param Integer　 利用人数
     * @param Integer　 コースプラン
     * @param Integer　 兄弟児利用
     * @return Integer 料金
     */
    private function getFeeByCourse($numberOfUse, $coursePlan, $siblingUse)
    {
        if ($numberOfUse === constUser::ONE_USE) {
            if (!empty($siblingUse)) return constUser::FEE_ONE_SIBLING;
            if ($coursePlan === constUser::COURSE_WEEKDAY) return constUser::FEE_ONE_WEEKDAY;
            if ($coursePlan === constUser::COURSE_HOLIDAY) return constUser::FEE_ONE_HOLIDAY;
        } else if ($numberOfUse === constUser::TWO_USE) {
            if (!empty($siblingUse)) return constUser::FEE_TWO_SIBLING;
            if ($coursePlan === constUser::COURSE_WEEKDAY) return constUser::FEE_TWO_WEEKDAY;
            if ($coursePlan === constUser::COURSE_HOLIDAY) return constUser::FEE_TWO_HOLIDAY;
        }
    }
}
