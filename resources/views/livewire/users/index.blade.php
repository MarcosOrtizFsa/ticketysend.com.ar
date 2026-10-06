<div class="space-y-6">
    <div>
        <flux:heading size="xl">Gestión de usuarios</flux:heading>
        <flux:text class="mt-1">Asigná roles sin modificar cuentas ni contraseñas.</flux:text>
    </div>

    <div class="max-w-md"><flux:input wire:model.live.debounce.300ms="search" label="Buscar" placeholder="Nombre o correo" /></div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr><th class="px-4 py-3">Usuario</th><th class="px-4 py-3">Correo</th><th class="px-4 py-3">Rol</th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="px-4 py-4 font-medium">{{ $user->name }} @if ($user->is(auth()->user()))<span class="text-xs text-zinc-500">(vos)</span>@endif</td>
                            <td class="px-4 py-4">{{ $user->email }}</td>
                            <td class="px-4 py-4">
                                <select wire:change="updateRole({{ $user->id }}, $event.target.value)" @disabled($user->is(auth()->user())) class="rounded-lg border-zinc-300 bg-white text-sm dark:border-zinc-700 dark:bg-zinc-800">
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
