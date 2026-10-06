<?php

namespace App\Livewire\Tickets;

use App\Enums\TicketPriority;
use App\Livewire\Forms\TicketForm;
use App\Models\Ticket;
use App\Services\TicketNotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Create extends Component
{
    public TicketForm $form;

    public function save(TicketNotificationService $notifications): void
    {
        Gate::authorize('create', Ticket::class);
        $validated = $this->form->validate();

        unset($validated['status']);

        $ticket = auth()->user()->tickets()->create($validated);
        $notifications->created($ticket);

        session()->flash('status', "El ticket {$ticket->reference} fue creado.");
        $this->redirectRoute('tickets.show', $ticket, navigate: true);
    }

    public function render(): View
    {
        Gate::authorize('create', Ticket::class);

        return view('livewire.tickets.create', [
            'priorities' => TicketPriority::cases(),
        ]);
    }
}
