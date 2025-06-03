<?php

namespace App\Helpers;

use App\Models\UserStore;
use Illuminate\Support\Str;

class PasswordHelper
{
    /**
     * Generates a default password for a staff member.
     * Format: ST<XX><001>! (e.g., STCA001!)
     *
     * @param string $store_id The ID of the store the staff belongs to.
     * @param string $store_role The staff's role in that store.
     * @param string|null $user_id Optional. If provided, it calculates the original number for a password reset. Otherwise, calculates the next number for a new user.
     * @return string
     */
    public static function generateStaffPassword(string $store_id, string $store_role, string $user_id = null): string
    {
        $prefix = 'ST';
        $roleInitials = strtoupper(Str::substr($store_role, 0, 2));
        $suffix = '!';

        if ($user_id) {
            // --- LOGIC FOR RESETTING an existing user's password ---
            // Find all staff in the same store with the same role, ordered by creation.
            $staffInRole = UserStore::where('store_id', $store_id)
                ->where('store_role', $store_role)
                ->orderBy('created_at', 'asc')
                ->pluck('user_id')
                ->toArray();
            
            // Find the position (index) of our user. Index + 1 is their sequential number.
            $userIndex = array_search($user_id, $staffInRole);
            $number = ($userIndex !== false) ? $userIndex + 1 : 1;

        } else {
            // --- LOGIC FOR CREATING a new user's password ---
            // Count existing staff to determine the next number in the sequence.
            $staffCount = UserStore::where('store_id', $store_id)
                                   ->where('store_role', $store_role)
                                   ->count();
            $number = $staffCount + 1;
        }
        
        $paddedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

        return $prefix . $roleInitials . $paddedNumber . $suffix;
    }
}