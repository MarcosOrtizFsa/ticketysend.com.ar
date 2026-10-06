<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <p class="eyebrow">Nueva solicitud</p>
        <flux:heading size="xl">Nuevo ticket</flux:heading>
        <flux:text class="mt-1">Describí el problema con la mayor claridad posible.</flux:text>
    </div>

    <form wire:submit="save" class="surface-card space-y-6 p-6 sm:p-8">
        <flux:input wire:model="form.subject" label="Asunto" maxlength="200" required />
        <flux:error name="form.subject" />
        <label class="block text-sm font-medium">Descripción
            <textarea wire:model="form.description" rows="8" required class="field-textarea"></textarea>
        </label>
        <flux:error name="form.description" />
        <label class="block text-sm font-medium">Prioridad
            <select wire:model="form.priority" class="field-select">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                @endforeach
            </select>
        </label>
        <flux:error name="form.priority" />
        <div class="flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 sm:flex-row dark:border-slate-800">
            <flux:button href="{{ route('tickets.index') }}" variant="ghost" wire:navigate>Cancelar</flux:button>
            <flux:button type="submit" variant="primary">Crear ticket</flux:button>
        </div>
    </form>
</div>
