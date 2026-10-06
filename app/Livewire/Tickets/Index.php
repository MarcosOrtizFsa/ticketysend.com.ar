<?php

namespace App\Livewire\Tickets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $priority = '';

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'status', 'priority'], true)) {
            $this->resetPage();
        }
    }

    public function render(): View
    {
        Gate::authorize('viewAny', Ticket::class);

        $user = auth()->user();
        $referenceId = preg_match('/^TKT-0*(\d+)$/i', trim($this->search), $matches)
            ? (int) $matches[1]
            : null;

        $tickets = Ticket::query()
            ->with(['creator', 'closedBy'])
            ->when(! $user->hasAnyRole(['admin', 'supervisor']), fn (Builder $query) => $query->whereBelongsTo($user, 'creator'))
            ->when($this->search !== '', function (Builder $query) use ($referenceId) {
                $query->where(function (Builder $query) use ($referenceId) {
                    $query->where('subject', 'like', '%'.$this->search.'%')
                        ->when($referenceId, fn (Builder $query) => $query->orWhereKey($referenceId));
                });
            })
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->priority !== '', fn (Builder $query) => $query->where('priority', $this->priority))
            ->latest()
            ->paginate(10);

        return view('livewire.tickets.index', [
            'tickets' => $tickets,
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
        ]);
    }
}
