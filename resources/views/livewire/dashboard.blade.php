<div class="space-y-7">
    <section class="relative overflow-hidden rounded-3xl bg-ink-900 px-6 py-9 text-white shadow-xl shadow-blue-950/10 sm:px-10 sm:py-12">
        <div class="absolute -right-16 -top-24 size-72 rounded-full border-[44px] border-brand-500/20"></div>
        <div class="absolute bottom-0 right-24 h-24 w-48 rounded-t-full bg-accent-500/10 blur-xl"></div>
        <div class="relative max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-300">Panel de soporte</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Hola, {{ Str::before($user->name, ' ') }}.</h1>
            <p class="mt-3 max-w-xl text-base leading-7 text-slate-300">Gestioná tus solicitudes y seguí cada actualización desde un solo lugar.</p>
            <div class="mt-7 flex flex-wrap gap-3">
                @can('create', App\Models\Ticket::class)
                    <flux:button href="{{ route('tickets.create') }}" variant="primary" wire:navigate>Crear nuevo ticket</flux:button>
                @endcan
                <a href="{{ route('tickets.index') }}" wire:navigate class="inline-flex items-center rounded-lg border border-white/20 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">Ver mis tickets</a>
            </div>
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-[0.75fr_1.25fr]">
        <section class="surface-card p-6">
            <p class="eyebrow">Tu perfil</p>
            <div class="mt-5 flex items-center gap-4">
                <span class="grid size-12 place-items-center rounded-2xl bg-brand-100 text-lg font-bold text-brand-700 dark:bg-blue-950 dark:text-blue-200">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                <div class="min-w-0">
                    <h2 class="truncate font-bold text-ink-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="truncate text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            <div class="mt-6 border-t border-slate-100 pt-5 dark:border-slate-800">
                <span class="status-pill bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 dark:bg-blue-950 dark:text-blue-200 dark:ring-blue-900">{{ $role }}</span>
            </div>
        </section>

        <section class="surface-card p-6">
            <div class="flex items-center justify-between gap-4">
                <div><p class="eyebrow">Accesos habilitados</p><h2 class="mt-1 text-lg font-bold text-ink-900 dark:text-white">Tus permisos</h2></div>
                <span aria-hidden="true" class="grid size-10 place-items-center rounded-xl bg-slate-100 text-lg dark:bg-slate-800">✓</span>
            </div>
            <ul class="mt-5 grid gap-2 sm:grid-cols-2">
                @forelse ($permissions as $permission)
                    <li class="flex items-center gap-2 rounded-xl bg-slate-50 px-3 py-2.5 text-sm text-slate-700 dark:bg-slate-800/70 dark:text-slate-200">
                        <span aria-hidden="true" class="size-1.5 rounded-full bg-brand-500"></span>{{ ucfirst($permission) }}
                    </li>
                @empty
                    <li class="text-sm text-slate-500">No hay permisos asignados.</li>
                @endforelse
            </ul>
        </section>
    </div>

    @can('gestionar usuarios')
        <section class="flex flex-col justify-between gap-4 rounded-2xl border border-dashed border-slate-300 p-5 sm:flex-row sm:items-center dark:border-slate-700">
            <div><h2 class="font-bold text-ink-900 dark:text-white">Administración de accesos</h2><p class="mt-1 text-sm text-slate-500">Revisá usuarios y asigná el rol adecuado.</p></div>
            <flux:button href="{{ route('users.index') }}" wire:navigate>Gestionar usuarios</flux:button>
        </section>
    @endcan
</div>
