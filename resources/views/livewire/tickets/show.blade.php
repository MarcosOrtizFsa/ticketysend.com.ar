<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
        <div>
            <p class="eyebrow">{{ $ticket->reference }}</p>
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

    <section class="surface-card overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-brand-500 via-blue-400 to-accent-500"></div>
        <div class="p-6 sm:p-8">
        <dl class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</dt><dd class="mt-2"><span @class(['status-pill', 'status-open' => $ticket->status->value === 'open', 'status-progress' => $ticket->status->value === 'in_progress', 'status-closed' => $ticket->status->value === 'closed'])>{{ $ticket->status->label() }}</span></dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Prioridad</dt><dd @class(['mt-2 font-bold', 'priority-high' => $ticket->priority->value === 'high', 'priority-medium' => $ticket->priority->value === 'medium', 'priority-low' => $ticket->priority->value === 'low'])>{{ $ticket->priority->label() }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Creado por</dt><dd class="mt-2 font-bold text-ink-900 dark:text-white">{{ $ticket->creator->name }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Fecha</dt><dd class="mt-2 font-bold text-ink-900 dark:text-white">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd></div>
        </dl>
        <div class="mt-8 border-t border-slate-200 pt-6 dark:border-slate-800">
            <h2 class="font-semibold">Descripción</h2>
            <p class="mt-3 whitespace-pre-line leading-7 text-slate-700 dark:text-slate-300">{{ $ticket->description }}</p>
        </div>
        @if ($ticket->closed_at)
            <div class="mt-8 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                Cerrado por {{ $ticket->closedBy?->name ?? 'usuario no disponible' }} el {{ $ticket->closed_at->format('d/m/Y H:i') }}.
            </div>
        @endif
        </div>
    </section>
</div>
