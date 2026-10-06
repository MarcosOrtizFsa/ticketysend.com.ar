<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <flux:heading size="xl">Editar {{ $ticket->reference }}</flux:heading>
        <flux:text class="mt-1">Actualizá la información y el estado operativo.</flux:text>
    </div>

    <form wire:submit="save" class="space-y-6 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
        <flux:input wire:model="form.subject" label="Asunto" maxlength="200" required />
        <flux:error name="form.subject" />
        <label class="block text-sm font-medium">Descripción
            <textarea wire:model="form.description" rows="8" required class="mt-2 block w-full rounded-lg border-zinc-300 bg-white dark:border-zinc-700 dark:bg-zinc-800"></textarea>
        </label>
        <flux:error name="form.description" />
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="block text-sm font-medium">Prioridad
                <select wire:model="form.priority" class="mt-2 block w-full rounded-lg border-zinc-300 bg-white dark:border-zinc-700 dark:bg-zinc-800">
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block text-sm font-medium">Estado
                <select wire:model="form.status" class="mt-2 block w-full rounded-lg border-zinc-300 bg-white dark:border-zinc-700 dark:bg-zinc-800">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        <flux:error name="form.priority" />
        <flux:error name="form.status" />
        <div class="flex justify-end gap-3">
            <flux:button href="{{ route('tickets.show', $ticket) }}" variant="ghost" wire:navigate>Cancelar</flux:button>
            <flux:button type="submit" variant="primary">Guardar cambios</flux:button>
        </div>
    </form>
</div>
