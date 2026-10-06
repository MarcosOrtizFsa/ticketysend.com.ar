<div class="space-y-6">
    <div>
        <p class="eyebrow">Administración</p>
        <flux:heading size="xl">Gestión de usuarios</flux:heading>
        <flux:text class="mt-1">Asigná roles sin modificar cuentas ni contraseñas.</flux:text>
    </div>

    <div class="max-w-md"><flux:input wire:model.live.debounce.300ms="search" label="Buscar" placeholder="Nombre o correo" /></div>

    <div class="surface-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
                    <tr><th class="px-4 py-3">Usuario</th><th class="px-4 py-3">Correo</th><th class="px-4 py-3">Rol</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="transition hover:bg-brand-50/40 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-4 font-medium">{{ $user->name }} @if ($user->is(auth()->user()))<span class="text-xs text-zinc-500">(vos)</span>@endif</td>
                            <td class="px-4 py-4">{{ $user->email }}</td>
                            <td class="px-4 py-4">
                                <select aria-label="Rol de {{ $user->name }}" wire:change="updateRole({{ $user->id }}, $event.target.value)" @disabled($user->is(auth()->user())) class="rounded-xl border-slate-300 bg-white text-sm shadow-sm dark:border-slate-700 dark:bg-slate-800">
                                    @foreach ($roles as $value => $label)
                                        <option value="{{ $value }}" @selected($user->hasRole($value))>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <flux:error name="role.{{ $user->id }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())<div class="border-t border-zinc-200 p-4 dark:border-zinc-800">{{ $users->links() }}</div>@endif
    </div>
</div>
