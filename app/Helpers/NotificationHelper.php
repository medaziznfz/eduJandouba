<?php

use App\Models\User;

if (!function_exists('notify')) {
    // Notify a single user
    function notify($userId, $title, $subtitle, $redirectLink)
    {
        // Retrieve the user by ID
        $user = User::find($userId);

        if (!$user) {
            return false; // User not found, handle error
        }

        // Create the notification
        return $user->notifications()->create([
            'title' => $title,
            'subtitle' => $subtitle,
            'redirect_link' => $redirectLink,
            'read' => false
        ]);
    }
}

if (!function_exists('notifyUniv')) {
    // Notify all users with the 'univ' role
    function notifyUniv($title, $subtitle, $redirectLink)
    {
        // Get all users with the 'univ' role
        $users = User::where('role', 'univ')->get();

        // Iterate over the users and send the notification
        foreach ($users as $user) {
            $user->notifications()->create([
                'title' => $title,
                'subtitle' => $subtitle,
                'redirect_link' => $redirectLink,
                'read' => false
            ]);
        }

        return true; // Return true if notifications were sent successfully
    }
}

if (!function_exists('notifyEtab')) {
    // Notify users with the 'etab' role and matching 'etablissement_id'
    function notifyEtab($etablissementId, $title, $subtitle, $redirectLink)
    {
        // Get all users with the 'etab' role and the matching etablissement_id
        $users = User::where('role', 'etab')
                     ->where('etablissement_id', $etablissementId)
                     ->get();

        // Iterate over the users and send the notification
        foreach ($users as $user) {
            $user->notifications()->create([
                'title' => $title,
                'subtitle' => $subtitle,
                'redirect_link' => $redirectLink,
                'read' => false
            ]);
        }

        return true; // Return true if notifications were sent successfully
    }
}

