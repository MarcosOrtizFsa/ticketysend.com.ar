<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
        <div>
            <flux:text>{{ $ticket->reference }}</flux:text>
            <flux:heading size="xl">{{ $ticket->subject }}</flux:heading>
        </div>
        <div class="flex flex-wrap gap-3">
            @if ($canEdit)
                <flux:button href="{{ route('tickets.edit', $ticket) }}" wire:navigate>Editar</flux:button>
            @endif
            @if ($canClose)
                <flux:button wire:click="close" wire:confirm="¿Confirmás el cierre de este ticket?" variant="danger">Cerrar ticket</flux:button>
            @endif
        </div>
    </div>

    <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
        <dl class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div><dt class="text-sm text-zinc-500">Estado</dt><dd class="mt-1 font-medium">{{ $ticket->status->label() }}</dd></div>
            <div><dt class="text-sm text-zinc-500">Prioridad</dt><dd class="mt-1 font-medium">{{ $ticket->priority->label() }}</dd></div>
            <div><dt class="text-sm text-zinc-500">Creado por</dt><dd class="mt-1 font-medium">{{ $ticket->creator->name }}</dd></div>
            <div><dt class="text-sm text-zinc-500">Fecha</dt><dd class="mt-1 font-medium">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd></div>
        </dl>
        <div class="mt-8 border-t border-zinc-200 pt-6 dark:border-zinc-800">
            <h2 class="font-semibold">Descripción</h2>
            <p class="mt-3 whitespace-pre-line text-zinc-700 dark:text-zinc-300">{{ $ticket->description }}</p>
        </div>
        @if ($ticket->closed_at)
            <div class="mt-8 rounded-lg bg-zinc-100 p-4 text-sm dark:bg-zinc-800">
                Cerrado por {{ $ticket->closedBy?->name ?? 'usuario no disponible' }} el {{ $ticket->closed_at->format('d/m/Y H:i') }}.
            </div>
        @endif
    </section>
</div>
