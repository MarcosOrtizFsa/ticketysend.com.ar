<x-layouts.auth>
    <flux:heading size="xl" class="text-center">Iniciar sesión</flux:heading>
    <flux:text class="mt-2 text-center">Ingresá con tu correo y contraseña.</flux:text>

    @if (session('status'))
        <div class="mt-5 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
        @csrf
        <flux:input name="email" type="email" label="Correo electrónico" value="{{ old('email') }}" required autofocus autocomplete="email" />
        <flux:error name="email" />
        <flux:input name="password" type="password" label="Contraseña" required autocomplete="current-password" viewable />
        <flux:error name="password" />
        <flux:checkbox name="remember" label="Recordarme" />
        <flux:button type="submit" variant="primary" class="w-full">Ingresar</flux:button>
    </form>

    <div class="mt-6 flex items-center justify-between text-sm">
        <a class="text-blue-600 hover:underline" href="{{ route('password.request') }}">Olvidé mi contraseña</a>
        <a class="text-blue-600 hover:underline" href="{{ route('register') }}">Crear cuenta</a>
    </div>
</x-layouts.auth>
