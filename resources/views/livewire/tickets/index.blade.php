<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <flux:heading size="xl">Tickets</flux:heading>
            <flux:text class="mt-1">Consultá y seguí las solicitudes de soporte.</flux:text>
        </div>
        @can('create', App\Models\Ticket::class)
            <flux:button href="{{ route('tickets.create') }}" variant="primary" wire:navigate>Nuevo ticket</flux:button>
        @endcan
    </div>

    <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900 md:grid-cols-3">
        <flux:input wire:model.live.debounce.300ms="search" label="Buscar" placeholder="Asunto o TKT-000001" />
        <label class="block text-sm font-medium">Estado
            <select wire:model.live="status" class="mt-2 block w-full rounded-lg border-zinc-300 bg-white text-sm dark:border-zinc-700 dark:bg-zinc-800">
                <option value="">Todos</option>
                @foreach ($statuses as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-medium">Prioridad
            <select wire:model.live="priority" class="mt-2 block w-full rounded-lg border-zinc-300 bg-white text-sm dark:border-zinc-700 dark:bg-zinc-800">
                <option value="">Todas</option>
                @foreach ($priorities as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
                        <th class="px-4 py-3">Ticket</th>
                        <th class="px-4 py-3">Creador</th>
                        <th class="px-4 py-3">Prioridad</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Creado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($tickets as $ticket)
                        <tr wire:key="ticket-{{ $ticket->id }}">
                            <td class="px-4 py-4">
                                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="font-medium text-blue-600 hover:underline">{{ $ticket->reference }}</a>
                                <div class="mt-1 max-w-md truncate">{{ $ticket->subject }}</div>
                            </td>
                            <td class="px-4 py-4">{{ $ticket->creator->name }}</td>
                            <td class="px-4 py-4">{{ $ticket->priority->label() }}</td>
                            <td class="px-4 py-4">{{ $ticket->status->label() }}</td>
                            <td class="whitespace-nowrap px-4 py-4">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-zinc-500">No se encontraron tickets.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tickets->hasPages())
            <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">{{ $tickets->links() }}</div>
        @endif
    </div>
</div>
