<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\User\Entities\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $email = $data['email'];
        $password = $data['password'];
        $exist = User::where('email', $email)->first();
        if ($exist && !$exist->hasRole('student')) {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $url = url($this->redirectTo);
                return redirect($url);
            }
        }


        $exist = User::where('email', $email)
                    ->whereNotNull('expiration_date')
                    ->where('expiration_date', '>=', date('Y-m-d'))->first();

        if ($exist && Auth::attempt(['email' => $email, 'password' => $password])) {
            $url = url($this->redirectTo);
            return redirect($url);
        }

        return redirect()->back();
    }
}
