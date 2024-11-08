<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
    public function respond(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->recipient_id;
    }
}