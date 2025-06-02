<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\UserStore;

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
            'password'     => 'required|string|min:6|confirmed',
            'store_role'   => 'required|string|max:100',
        ]);

        // Create the user as staffs
        $user = User::create([
            'name'         => $validatedData['name'],
            'email'        => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'role'         => 'Staff',
            'password'     => bcrypt($validatedData['password']),
            'status'       => 1,
        ]);

        // Attach staffs to store with custom role in pivot
        $store->staffs()->attach($user->user_id, [
            'store_role' => $validatedData['store_role'],
            'status'     => 1,
            'start_date' => now(),
        ]);

        return redirect()->route('backend.store.show', $store->store_id)
            ->with('success', 'staffs registered successfully!');
    }

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