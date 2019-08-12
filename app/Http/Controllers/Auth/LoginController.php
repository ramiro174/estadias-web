<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;

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
    protected $redirectTo = '/home';

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
        $credentials = $request->only('email', 'password');
        $user = User::with('rol')->where('email', $credentials['email'])->where('password', $credentials['password'])->first();
        if($user){
            if (Auth::loginUsingId($user->id, true)) {
                // dd(Auth::user());
                return redirect()->intended('/home');
            }
        }
        return back()->with('error', 'Usuario no encontrado');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }
}
