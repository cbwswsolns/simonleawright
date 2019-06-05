<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    protected $redirectTo = '/user';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Custom logout method
     *
     * @param \Illuminate\Http\Request $request [the current request instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->performLogout($request);

        return redirect()->route('homepage.display');
    }
}
