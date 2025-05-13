<?php

namespace App\Policies;

use App\Models\ApplicationRequest;
use App\Models\User;

class ApplicationRequestPolicy
{
    /**
     * Determine whether the user can view any application requests
     * (used for the index page).
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'etab' || $user->role === 'univ';
    }



    /**
     * Determine whether the user can view a given application request.
     */
    public function view(User $user, ApplicationRequest $app): bool
    {
        // same check as “manage”
        return $this->manage($user, $app);
    }

    /**
     * Determine whether the user can manage (accept/reject) the request.
     */
    public function manage(User $user, ApplicationRequest $app): bool
    {
        if ($user->role === 'etab') {
            return $user->etablissement_id === $app->user->etablissement_id;
        }

        if ($user->role === 'univ') {
            // only if already approved by etab
            return $app->etab_confirmed === true;
        }

        return false;
    }




    // leave the others unimplemented or return false…
}
