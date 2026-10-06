<x-layouts.auth>
    <flux:heading size="xl" class="text-center">Recuperar contraseña</flux:heading>
    <flux:text class="mt-2 text-center">Te enviaremos un enlace si el correo está registrado.</flux:text>
    @if (session('status'))
        <div class="mt-5 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf
        <flux:input name="email" type="email" label="Correo electrónico" value="{{ old('email') }}" required autofocus />
        <flux:error name="email" />
        <flux:button type="submit" variant="primary" class="w-full">Enviar enlace</flux:button>
    </form>
    <p class="mt-6 text-center text-sm"><a class="text-blue-600 hover:underline" href="{{ route('login') }}">Volver al acceso</a></p>
</x-layouts.auth>
