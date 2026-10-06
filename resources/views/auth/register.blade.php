<x-layouts.auth>
    <flux:heading size="xl" class="text-center">Crear cuenta</flux:heading>
    <flux:text class="mt-2 text-center">Registrate para acceder al sistema.</flux:text>

    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5">
        @csrf
        <flux:input name="name" label="Nombre" value="{{ old('name') }}" required autofocus autocomplete="name" />
        <flux:error name="name" />
        <flux:input name="email" type="email" label="Correo electrónico" value="{{ old('email') }}" required autocomplete="email" />
        <flux:error name="email" />
        <flux:input name="password" type="password" label="Contraseña" required autocomplete="new-password" viewable />
        <flux:error name="password" />
        <flux:input name="password_confirmation" type="password" label="Confirmar contraseña" required autocomplete="new-password" viewable />
        <flux:button type="submit" variant="primary" class="w-full">Registrarme</flux:button>
    </form>

    <p class="mt-6 text-center text-sm">¿Ya tenés cuenta? <a class="text-blue-600 hover:underline" href="{{ route('login') }}">Iniciar sesión</a></p>
</x-layouts.auth>
