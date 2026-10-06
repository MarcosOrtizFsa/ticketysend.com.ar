<?php

namespace App\Livewire\Tickets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Services\TicketNotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Show extends Component
{
    public Ticket $ticket;

    public function mount(): void
    {
        Gate::authorize('view', $this->ticket);
    }

    public function close(TicketNotificationService $notifications): void
    {
        Gate::authorize('close', $this->ticket);

        DB::transaction(function (): void {
            $this->ticket->update([
                'status' => TicketStatus::Closed,
                'closed_by' => auth()->id(),
                'closed_at' => now(),
            ]);
        });

        $this->ticket->refresh()->load(['creator', 'closedBy']);
        $notifications->closed($this->ticket);
        session()->flash('status', "El ticket {$this->ticket->reference} fue cerrado.");
    }

    public function render(): View
    {
        Gate::authorize('view', $this->ticket);

        return view('livewire.tickets.show', [
            'canEdit' => Gate::allows('update', $this->ticket),
            'canClose' => Gate::allows('close', $this->ticket),
        ]);
    }
}
