<?php

namespace App\Livewire\Tickets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Livewire\Forms\TicketForm;
use App\Models\Ticket;
use App\Services\TicketNotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Edit extends Component
{
    public Ticket $ticket;

    public TicketForm $form;

    public function mount(): void
    {
        Gate::authorize('update', $this->ticket);
        $this->form->fillFrom($this->ticket);
    }

    public function save(TicketNotificationService $notifications): void
    {
        Gate::authorize('update', $this->ticket);
        $this->ticket->update($this->form->validate());
        $notifications->updated($this->ticket->fresh(['creator']));

        session()->flash('status', "El ticket {$this->ticket->reference} fue actualizado.");
        $this->redirectRoute('tickets.show', $this->ticket, navigate: true);
    }

    public function render(): View
    {
        Gate::authorize('update', $this->ticket);

        return view('livewire.tickets.edit', [
            'priorities' => TicketPriority::cases(),
            'statuses' => [TicketStatus::Open, TicketStatus::InProgress],
        ]);
    }
}
