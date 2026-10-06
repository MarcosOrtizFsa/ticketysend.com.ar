<?php

namespace App\Services;

use App\Mail\TicketClosedMail;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketUpdatedMail;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;

class TicketNotificationService
{
    public function created(Ticket $ticket): void
    {
        Mail::to($ticket->creator)->queue(new TicketCreatedMail($ticket));
    }

    public function updated(Ticket $ticket): void
    {
        Mail::to($ticket->creator)->queue(new TicketUpdatedMail($ticket));
    }

    public function closed(Ticket $ticket): void
    {
        Mail::to($ticket->creator)->queue(new TicketClosedMail($ticket));
    }
}
