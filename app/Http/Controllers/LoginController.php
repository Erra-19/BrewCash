<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // dd(Auth::attempt($credentials));
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'Owner') {
                Auth::logout();
                return back()->with('error', 'User not permitted!');
            }
            if (Auth::user()->status == 0) {
                Auth::logout();
                return back()->with('error', 'User not activated');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('backend.dashboard'));
        }
        return back()->with('error', 'Wrong email or password');
    }

    public function logoutBackend(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login.form'));
    }
}
