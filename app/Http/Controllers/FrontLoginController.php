<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FrontLoginController extends Controller
{
    /**
     * Show the staff login form.
     */
    public function showLoginForm()
    {
        return view('frontend.login');
    }

    /**
     * Handle the staff login request.
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in using user_id and password
        if (Auth::attempt([
            'user_id' => $credentials['user_id'],
            'password' => $credentials['password'],
            'role'     => ['Staff', 'Owner'],
            'status'   => 1
        ])) {
            $request->session()->regenerate();

            return redirect()->intended('/front/dashboard');
        }

        // If login fails
        return back()->withErrors([
            'login_error' => 'User ID or password is incorrect, or you do not have staff access.',
        ])->withInput();
    }

    /**
     * Log the staff out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.login');
    }
}