<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $view = \auth()->user()->nik ?? false;

        return view('change-password', [
            'view' => $view ? 'admin' : 'vendor',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        $auth = \auth()->user();
        $view = $auth->nik ?? false;
        if ($view) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        } else {
            Vendor::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        }
        $request->session()->flash('status', 'Password has changed');

        return \redirect()->route($view ? 'admin.home' : 'vendor.home');
    }
}
