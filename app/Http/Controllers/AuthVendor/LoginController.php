<?php

namespace App\Http\Controllers\AuthVendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Vendor;

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
            'password' => 'required'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $model = Vendor::where('email', $request->email)->first();

        if ($model->status == 0)
            return redirect()->route('vendor.login')->with('error', trans('validation.vendor_not_validate'));

        if (Auth::guard('vendor')->attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('vendor.home'));
        }

        return redirect()->back()->withInputs($request->only('email'));
    }

    public function showRegisterForm ()
    {
        return view('authVendor.register');
    }

    public function register (Request $request)
    {
        $model = new Vendor;
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->password = bcrypt($request->input('password'));
        $model->company_type = 1;
        $model->company_from = 1;
        $model->npwp = $request->input('npwp');
        $model->country_id = 1;
        $model->province_id = 1;
        $model->regencies_id = 1;
        $model->district_id = 1;
        $model->address = $request->input('address');
        $model->status = 0;
        $model->save();

        return redirect()->route('vendor.login');
    }

    public function logout ()
    {
        if (Auth::guard('vendor')->check()) {
            Auth::guard('vendor')->logout();
        }
    
        return redirect('vendor/login');
    }
}
