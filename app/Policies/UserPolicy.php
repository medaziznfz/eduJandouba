<?php
namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Allow all users to update their own profile.
     */
    public function updateProfile(User $user): bool
    {
        return true;  // This allows all users to update their profile
    }
}
