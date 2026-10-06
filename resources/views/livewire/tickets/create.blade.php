<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <flux:heading size="xl">Nuevo ticket</flux:heading>
        <flux:text class="mt-1">Describí el problema con la mayor claridad posible.</flux:text>
    </div>

    <form wire:submit="save" class="space-y-6 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
        <flux:input wire:model="form.subject" label="Asunto" maxlength="200" required />
        <flux:error name="form.subject" />
        <label class="block text-sm font-medium">Descripción
            <textarea wire:model="form.description" rows="8" required class="mt-2 block w-full rounded-lg border-zinc-300 bg-white dark:border-zinc-700 dark:bg-zinc-800"></textarea>
        </label>
        <flux:error name="form.description" />
        <label class="block text-sm font-medium">Prioridad
            <select wire:model="form.priority" class="mt-2 block w-full rounded-lg border-zinc-300 bg-white dark:border-zinc-700 dark:bg-zinc-800">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                @endforeach
            </select>
        </label>
        <flux:error name="form.priority" />
        <div class="flex justify-end gap-3">
            <flux:button href="{{ route('tickets.index') }}" variant="ghost" wire:navigate>Cancelar</flux:button>
            <flux:button type="submit" variant="primary">Crear ticket</flux:button>
        </div>
    </form>
</div>
