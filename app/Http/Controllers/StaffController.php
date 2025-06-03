<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\UserStore;
use Illuminate\Support\Str; // Import the Str class

class StaffController extends Controller
{
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

        // Validate input
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'nullable|string|min:6|confirmed', // 'confirmed' will look for a 'password_confirmation' field
            'store_role'   => 'required|string|max:100',
        ]);

        // Determine the password
        if (!empty($validatedData['password'])) {
            $password = $validatedData['password'];
        } else {
            // Generate the default password if none is provided
            $password = $this->generateDefaultPassword($store->store_id, $validatedData['store_role']);
        }

        // Create the user as staffs
        $user = User::create([
            'name'         => $validatedData['name'],
            'email'        => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'role'         => 'Staff',
            'password'     => bcrypt($password), // Use the determined password
            'status'       => 1,
        ]);

        // Attach staffs to store with custom role in pivot
        $store->staffs()->attach($user->user_id, [
            'store_role' => $validatedData['store_role'],
            'status'     => 1,
            'start_date' => now(),
        ]);

        return redirect()->route('backend.store.show', $store->store_id)
            ->with('success', 'Staffs registered successfully! Default password has been set if you left the password field blank.');
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
        $staffs = User::findOrFail($user_id);

        // Validate input (email unique except this user)
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $staffs->user_id . ',user_id',
            'phone_number' => 'required|string|max:20',
            'store_role'   => 'required|string|max:100',
            'status'       => 'required|in:0,1',
        ]);

        // Update User fields (not password here)
        $staffs->update([
            'name'         => $validatedData['name'],
            'email'        => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        // Update pivot fields (store_role and status)
        $store->staffs()->updateExistingPivot($staffs->user_id, [
            'store_role' => $validatedData['store_role'],
            'status'     => $validatedData['status'],
        ]);

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', 'staffs updated successfully!');
    }

    /**
     * Remove the specified staffs from a specific store.
     */
    public function destroy($store_id, $user_id)
    {
        $store = Store::findOrFail($store_id);

        // Detach staffs from this store only (does not delete user)
        $store->staffs()->detach($user_id);

        return redirect()->route('backend.staff.index', $store->store_id)
            ->with('success', 'staffs removed from store successfully!');
    }
}