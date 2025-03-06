<?php

namespace App\Policies\V1;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Ticket $ticket)
    {
        if ($user->isInRole('tickets:update')) {
            return true;
        }
        return $user->id === $ticket->user_id;
    }
}