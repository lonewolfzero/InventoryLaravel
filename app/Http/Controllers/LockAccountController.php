<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LockAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lockscreen()
    {
        if ( !session()->has('uri') ){
            session(['locked' => 'true', 'uri' => url()->previous()]);
        }

        $title = 'Locked';
        $user = auth()->user();

        toastr()->success('Account Locked Successfully!');
        return view('auth.locked', compact('title', 'user'));
    }

    public function unlock(Request $request)
    {
        $password = $request->password;
        $this->validate($request, [
            'password' => 'required|string',
        ]);

        if(\Hash::check($password, auth()->user()->password)){
            $uri = $request->session()->get('uri');
            $request->session()->forget(['locked', 'uri']);

            toastr()->success('Welcome Back! ' . auth()->user()->name);
            return redirect($uri);
        }

        $title = 'Locked';
        $user = auth()->user();

        toastr()->error('Your Password Missmatch with Your Account.');
        return view('auth.locked', compact('title', 'user'));
    }
}
