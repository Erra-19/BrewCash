<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\UserStore;
use Illuminate\Support\Str;
use App\Traits\LoggableActivity;

class StaffController extends Controller
{
    use LoggableActivity;
    /**
     * Show staffs registration form for a specific store.
     */
    public function create($store_id)
    {
        $store = Store::findOrFail($store_id);
        return view('backend.v_staff.create', [
            'store' => $store
        ]);
    }

    /**
     * Store a newly registered staffs member for a store.
     */
    public function store(Request $request, $store_id)
    {
        $store = Store::findOrFail($store_id);
        $user = Auth::user();

        // --- PERMISSION LOGIC ---
        // Admins cannot create other Admins or Managers
        $roleValidation = 'required|string|max:100';
        if ($user->isStaff() && $user->staffs->find($store_id)->pivot->store_role === 'Admin') {
            $roleValidation = [
                'required', 'string', 'max:100',
                Rule::notIn(['Admin', 'Manager']),
            ];
        }

        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'nullable|string|min:6|confirmed',
            'store_role'   => $roleValidation,
        ], [
            'store_role.not_in' => 'Admins are not permitted to create staff with the Admin or Manager role.', // Custom error message
        ]);

        // (The rest of your store logic remains the same...)
        $password = !empty($validatedData['password'])
            ? $validatedData['password']
            : $this->generateDefaultPassword($store->store_id, $validatedData['store_role']);

        $newStaff = User::create([
            'name'         => $validatedData['name'],
            'email'        => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'role'         => 'Staff',
            'password'     => bcrypt($password),
            'status'       => 1,
        ]);

        $store->staffs()->attach($newStaff->user_id, [
            'store_role' => $validatedData['store_role'],
            'status'     => 1,
            'start_date' => now(),
        ]);

        $this->logActivity(
            type: 'Staff',
            action: 'Registered new staff',
            meta: [
                'staff_name' => $newStaff->name,
                'staff_email' => $newStaff->email,
                'assigned_role' => $request->store_role
            ],
            store_id: $store->store_id
        );

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', 'Staff registered successfully!');
    }

    /**
     * Generates a default password for a new staff member.
     * Format: ST<XX><001>! (e.g., STCA001!)
     *
     * @param string $store_id
     * @param string $store_role
     * @return string
     */
    private function generateDefaultPassword(string $store_id, string $store_role): string
    {
        // 1. Get the prefix "ST"
        $prefix = 'ST';

        // 2. Get the first two letters of the store role, in uppercase.
        $roleInitials = strtoupper(Str::substr($store_role, 0, 2));

        // 3. Find the number of existing staff with the same role in the same store.
        $staffCount = UserStore::where('store_id', $store_id)
                               ->where('store_role', $store_role)
                               ->count();
        
        // The new staff will be the next number in sequence.
        $nextNumber = $staffCount + 1;

        // 4. Pad the number with leading zeros to make it 3 digits long.
        $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // 5. Add the suffix "!"
        $suffix = '!';

        // 6. Combine all parts to create the final password.
        return $prefix . $roleInitials . $paddedNumber . $suffix;
    }

    // ... (the rest of your controller methods: index, edit, update, destroy)
    
    /**
     * List all staffs for a given store.
     */
    public function index($store_id)
    {
        $store = Store::with(['staffs' => function($q) {
            $q->orderBy('name');
        }])->findOrFail($store_id);

        return view('backend.v_staff.index', [
            'store' => $store,
            'staffList' => $store->staffs,
        ]);
    }
    public function edit($store_id, $user_id)
    {
        $store = Store::findOrFail($store_id);
        $staffs = $store->staffs()->where('users.user_id', $user_id)->firstOrFail();
        // Load pivot data for this staffs-store relationship
        return view('backend.v_staff.edit', [
            'store' => $store,
            'staffs' => $staffs,
            'judul' => 'Edit staffs'
        ]);
    }

    /**
     * Update the specified staffs in a specific store.
     */
    public function update(Request $request, $store_id, $user_id)
    {
        $store = Store::findOrFail($store_id);
        $staff = User::findOrFail($user_id);
        $currentUser = Auth::user();

    // Storing original data for logging comparison
        $oldData = [
            'name' => $staff->name,
            'email' => $staff->email,
            'phone_number' => $staff->phone_number,
            'store_role' => $staff->staffs->find($store_id)->pivot->store_role,
            'status' => $staff->staffs->find($store_id)->pivot->status,
        ];

        // --- PERMISSION LOGIC --- (This part is correct)
        if ($currentUser->isStaff() && $currentUser->staffs->find($store_id)->pivot->store_role === 'Admin') {
            // ... (admin update logic)
        } else {
            // ... (owner update logic)
        }

        $this->logActivity(
            type: 'Staff',
            action: 'Updated staff details', // FIX: Correct action description
            meta: [
                'staff_id' => $staff->user_id,
                'staff_name' => $staff->name, // FIX: Use the correct variable
                'details' => $request->except(['_token', '_method']) // Log what was submitted
            ],
            store_id: $store->store_id
        );

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', 'Staff updated successfully!');
    }

    /**
     * Remove the specified staffs from a specific store.
     */
    public function destroy($store_id, $user_id)
    {
        $store = Store::findOrFail($store_id);
        $staffToRemove = $store->staffs()->find($user_id);
        $currentUser = Auth::user();

    // --- PERMISSION LOGIC --- (This part is correct)
        if ($currentUser->isStaff() && $currentUser->staffs->find($store_id)->pivot->store_role === 'Admin') {
        // ... (permission logic)
        }
    
    // --- CORRECTED LOGGING ---
    // Log the activity BEFORE detaching, so we can access staff details
        $this->logActivity(
            type: 'Staff',
            action: 'Removed staff from store', // FIX: Correct action description
            meta: [
                'staff_id' => $staffToRemove->user_id,
                'staff_name' => $staffToRemove->name, // FIX: Use the correct variable
                'staff_email' => $staffToRemove->email,
                'removed_from_role' => $staffToRemove->pivot->store_role
            ],
            store_id: $store->store_id
        );

        $store->staffs()->detach($user_id);

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', 'Staff removed from store successfully!');
    }
}