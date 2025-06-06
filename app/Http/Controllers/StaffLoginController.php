<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\LoggableActivity;

class StaffLoginController extends Controller
{
    use LoggableActivity;
    public function showLoginForm()
    {
        return view('backend.v_login.admin_login', [
            'title' => 'Backend Staff Login',
        ]);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'user_id' => 'required|string',
        'password' => 'required|string',
    ]);
    
    if (Auth::guard('staff')->attempt($credentials)) {  
        $user = Auth::guard('staff')->user();

        // This single check handles both role and status
        if ($user->role !== 'Staff' || $user->status == 0) {
            Auth::guard('staff')->logout();
            return back()->withErrors(['user_id' => 'Access denied or account inactive.'])->onlyInput('user_id');
        }

        $backendAccessAssignments = $user->staffs()
            ->wherePivot('status', 1)
            ->wherePivotIn('store_role', ['Manager', 'Admin'])
            ->get();

        // This single check correctly verifies if they have the required role
        if ($backendAccessAssignments->isEmpty()) {
            Auth::guard('staff')->logout();
            return back()->withErrors(['user_id' => 'You do not have the required backend role (Manager or Admin).'])->onlyInput('user_id');
        }
        
        $request->session()->regenerate();
        
        // This logic correctly sets the active store
        if ($backendAccessAssignments->count() === 1) {
            $selectedStore = $backendAccessAssignments->first();
            $request->session()->put('active_store_id', $selectedStore->store_id);
        } else {
            // Handle multiple store assignments if necessary, otherwise leave blank
        }

        // Log the successful login
        $this->logActivity(
            type: 'Authentication',
            action: 'Staff logged in to backend',
            meta: ['ip_address' => $request->ip()]
        );

        return redirect()->intended(route('backend.dashboard'));
    }

    // This part handles the failed login attempt
    $user = User::where('user_id', $credentials['user_id'])->first();
    if ($user) {
        $this->logActivity(
            type: 'Authentication',
            action: 'Failed backend login attempt',
            meta: ['attempted_user_id' => $user->user_id, 'ip_address' => $request->ip()]
        );
    }

    return back()->withErrors(['user_id' => 'Invalid credentials.'])->onlyInput('user_id');
}

    public function logout(Request $request)
    {
        $user = Auth::guard('staff')->user();
        if ($user) {
            $this->logActivity(
                type: 'Authentication', 
                action: 'Staff logged out',
                meta: [
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'last_active_store' => session('active_store_id')
                ]
            );
        }
        Auth::guard('staff')->logout();
        $request->session()->forget(['active_store_id', 'active_staff_admin_store_id', 'staff_store_selection_mode']);
        return redirect()->route('backend.admin.login.form');
    }
}