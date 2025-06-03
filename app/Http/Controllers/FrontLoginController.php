<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Support\Facades\Hash;
use App\Helpers\PasswordHelper;


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
    public function resetPassword($store_id, $user_id)
    {
        $store = Store::findOrFail($store_id);
        $staffUser = User::findOrFail($user_id);

        $userStoreInfo = UserStore::where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->firstOrFail();

        // Use the new, unified helper to generate the password
        $defaultPassword = PasswordHelper::generateStaffPassword(
            $store->store_id,
            $userStoreInfo->store_role,
            $staffUser->user_id // Pass user_id for reset logic
        );
        
        $staffUser->password = Hash::make($defaultPassword);
        $staffUser->save();

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', "Password for {$staffUser->name} has been reset. The new password is: " . $defaultPassword);
    }
    public function showForgotForm()
    {
        return view('frontend.forgot');
    }


    public function verifyStaffInfo(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
        ]);

        // Find a user where all three fields match exactly
        $user = User::where('user_id', $credentials['user_id'])
            ->where('email', $credentials['email'])
            ->where('phone_number', $credentials['phone_number'])
            ->where('role', 'Staff') // Ensure it's a staff account
            ->first();

        if ($user) {
            // If details match, store the user_id in the session for the next step
            // and redirect to the confirmation page.
            $request->session()->flash('verified_user_id_for_reset', $user->user_id);
            return redirect()->route('frontend.staff.reset.confirm');
        }

        // If no match, redirect back with a generic error
        return back()->withErrors([
            'verification_error' => 'The provided information does not match our records. Please try again.',
        ])->withInput();
    }

    /**
     * STEP 3: Show the final confirmation page.
     */
    public function showResetConfirmForm(Request $request)
    {
        // Ensure the user has been verified in the previous step
        if (!$request->session()->has('verified_user_id_for_reset')) {
            // If not, redirect them back to the start
            return redirect()->route('frontend.staff.forgot');
        }

        return view('frontend.reset');
    }

    /**
     * STEP 4: Process the final password reset.
     */
    public function processReset(Request $request)
    {
        // Double-check the session and get the user ID
        if (!$request->session()->has('verified_user_id_for_reset')) {
            return redirect()->route('frontend.staff.forgot')->withErrors(['error' => 'Verification expired. Please start over.']);
        }
        
        $userId = $request->session()->get('verified_user_id_for_reset');
        $user = User::findOrFail($userId);

        // To generate the correct password, we need the store_id and store_role.
        // We'll use the first store they are associated with.
        $userStore = $user->staffs()->first();

        if (!$userStore) {
            return redirect()->route('frontend.login')->withErrors(['login_error' => 'Cannot reset password. User is not associated with any store.']);
        }
        
        // Use the unified helper to generate the password
        $defaultPassword = PasswordHelper::generateStaffPassword(
            $userStore->store_id,
            $userStore->pivot->store_role,
            $user->user_id
        );

        // Update the password and save the user
        $user->password = Hash::make($defaultPassword);
        $user->save();

        // Redirect to login with a success message.
        // IMPORTANT: For security, DO NOT display the new password here.
        return redirect()->route('frontend.login')
            ->with('success', 'Your password has been successfully reset. Please contact your manager to receive your new temporary password.');
    }
}