<div class="space-y-8">
    <div>
        <flux:heading size="xl">Bienvenido, {{ $user->name }}</flux:heading>
        <flux:text class="mt-2">Tu acceso al sistema está activo.</flux:text>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
            <flux:heading size="lg">Rol</flux:heading>
            <span class="mt-4 inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-950 dark:text-blue-200">
                {{ $role }}
            </span>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
            <flux:heading size="lg">Permisos disponibles</flux:heading>
            <ul class="mt-4 space-y-2 text-sm">
                @forelse ($permissions as $permission)
                    <li class="rounded-lg bg-zinc-100 px-3 py-2 dark:bg-zinc-800">{{ ucfirst($permission) }}</li>
                @empty
                    <li class="text-zinc-500">No hay permisos asignados.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <div class="flex flex-wrap gap-3">
        <flux:button href="{{ route('tickets.index') }}" variant="primary" wire:navigate>Ver tickets</flux:button>
        @can('create', App\Models\Ticket::class)
            <flux:button href="{{ route('tickets.create') }}" wire:navigate>Crear ticket</flux:button>
        @endcan
        @can('gestionar usuarios')
            <flux:button href="{{ route('users.index') }}" wire:navigate>Gestionar usuarios</flux:button>
        @endcan
    </div>
</div>
