<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('ver tickets');
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if (! $user->can('ver tickets')) {
            return false;
        }

        return $user->hasAnyRole(['admin', 'supervisor'])
            || $ticket->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('crear tickets');
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasAnyRole(['admin', 'supervisor'])
            && $user->can('editar tickets');
    }

    public function close(User $user, Ticket $ticket): bool
    {
        return $user->hasAnyRole(['admin', 'supervisor'])
            && $user->can('cerrar tickets');
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
