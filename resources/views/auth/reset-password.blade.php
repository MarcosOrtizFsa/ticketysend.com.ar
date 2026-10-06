<x-layouts.auth>
    <flux:heading size="xl" class="text-center">Nueva contraseña</flux:heading>
    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <flux:input name="email" type="email" label="Correo electrónico" value="{{ old('email', $request->email) }}" required readonly />
        <flux:error name="email" />
        <flux:input name="password" type="password" label="Contraseña" required autocomplete="new-password" viewable />
        <flux:error name="password" />
        <flux:input name="password_confirmation" type="password" label="Confirmar contraseña" required autocomplete="new-password" viewable />
        <flux:button type="submit" variant="primary" class="w-full">Restablecer contraseña</flux:button>
    </form>
</x-layouts.auth>
