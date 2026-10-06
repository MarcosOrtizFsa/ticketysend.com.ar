<div class="space-y-7">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="eyebrow">Mesa de ayuda</p>
            <flux:heading size="xl">Tickets</flux:heading>
            <flux:text class="mt-2">Consultá el estado y el historial de cada solicitud.</flux:text>
        </div>
        @can('create', App\Models\Ticket::class)
            <flux:button href="{{ route('tickets.create') }}" variant="primary" wire:navigate>Nuevo ticket</flux:button>
        @endcan
    </div>

    <section aria-label="Filtros de tickets" class="surface-card grid gap-4 p-5 md:grid-cols-3">
        <flux:input wire:model.live.debounce.300ms="search" label="Buscar" placeholder="Asunto o TKT-000001" />
        <label class="block text-sm font-medium">Estado
            <select wire:model.live="status" class="field-select">
                <option value="">Todos</option>
                @foreach ($statuses as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-medium">Prioridad
            <select wire:model.live="priority" class="field-select">
                <option value="">Todas</option>
                @foreach ($priorities as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </label>
    </section>

    <div class="surface-card overflow-hidden">
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3">Ticket</th>
                        <th class="px-4 py-3">Creador</th>
                        <th class="px-4 py-3">Prioridad</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Creado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($tickets as $ticket)
                        <tr wire:key="ticket-{{ $ticket->id }}" class="transition hover:bg-brand-50/40 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-4">
                                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="font-bold text-brand-700 hover:underline dark:text-blue-300">{{ $ticket->reference }}</a>
                                <div class="mt-1 max-w-md truncate font-medium text-ink-900 dark:text-white">{{ $ticket->subject }}</div>
                            </td>
                            <td class="px-4 py-4">{{ $ticket->creator->name }}</td>
                            <td class="px-4 py-4"><span @class(['font-semibold', 'priority-high' => $ticket->priority->value === 'high', 'priority-medium' => $ticket->priority->value === 'medium', 'priority-low' => $ticket->priority->value === 'low'])>{{ $ticket->priority->label() }}</span></td>
                            <td class="px-4 py-4"><span @class(['status-pill', 'status-open' => $ticket->status->value === 'open', 'status-progress' => $ticket->status->value === 'in_progress', 'status-closed' => $ticket->status->value === 'closed'])><span aria-hidden="true" class="size-1.5 rounded-full bg-current"></span>{{ $ticket->status->label() }}</span></td>
                            <td class="whitespace-nowrap px-4 py-4">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-zinc-500">No se encontraron tickets.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">
            @forelse ($tickets as $ticket)
                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate wire:key="ticket-mobile-{{ $ticket->id }}" class="block p-5 transition hover:bg-brand-50/50 dark:hover:bg-slate-800/50">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0"><p class="text-xs font-bold text-brand-700 dark:text-blue-300">{{ $ticket->reference }}</p><h2 class="mt-1 truncate font-bold text-ink-900 dark:text-white">{{ $ticket->subject }}</h2></div>
                        <span @class(['status-pill shrink-0', 'status-open' => $ticket->status->value === 'open', 'status-progress' => $ticket->status->value === 'in_progress', 'status-closed' => $ticket->status->value === 'closed'])>{{ $ticket->status->label() }}</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs text-slate-500"><span>{{ $ticket->creator->name }}</span><span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span></div>
                </a>
            @empty
                <p class="px-5 py-10 text-center text-sm text-slate-500">No se encontraron tickets.</p>
            @endforelse
        </div>
        @if ($tickets->hasPages())
            <div class="border-t border-slate-200 p-4 dark:border-slate-800">{{ $tickets->links() }}</div>
        @endif
    </div>
</div>
