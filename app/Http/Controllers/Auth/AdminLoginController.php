<?php
namespace App\Http\Controllers\Auth;

use Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }


    /**
     * Show the Login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }


    /**
     * Login Administrator
     *
     * @param \Illuminate\Http\Request $request [the current request instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate(
            $request,
            ['email'   => 'required|email',
             'password' => 'required|min:6']
        );

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
