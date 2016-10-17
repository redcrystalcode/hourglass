<?php

namespace Hourglass\Http\Controllers\Auth;

use Hourglass\Http\Controllers\Controller;
use Hourglass\Models\Account;
use Hourglass\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use RedCrystal\ValidationRules\UniqueValidationRule;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/app';

    /**
     * @var string
     */
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'account' => ['required', (new UniqueValidationRule('accounts', 'name'))->toString()],
            'timezone' => ['required', 'timezone'],
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', (new UniqueValidationRule('users', 'username'))->toString()],
            'email' => ['required', 'email', 'max:255', (new UniqueValidationRule('users', 'email'))->toString()],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \Hourglass\Models\User
     */
    protected function create(array $data)
    {
        $account = Account::create([
            'name' => $data['account'],
            'timezone' => $data['timezone'],
        ]);
        
        $user = new User([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'admin'
        ]);
        
        $account->users()->save($user);
        
        return $user;
    }
}
