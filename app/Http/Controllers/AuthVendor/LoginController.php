<?php

namespace App\Http\Controllers\AuthVendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('authVendor.login');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required:email',
            'password' => 'required|min:6'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if( Auth::guard('vendor')->attempt($credential, $request->member) ) {
            return redirect()->intended(route('vendor.home'));
        }

        return redirect()->back()->withInputs($request->only('email','remember'));
    }
}
