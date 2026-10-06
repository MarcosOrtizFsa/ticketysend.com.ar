<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <header class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <nav class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:button type="submit" variant="ghost">Cerrar sesión</flux:button>
                    </form>
                @endauth
            </nav>
        </header>

        <main class="mx-auto w-full max-w-5xl px-4 py-10 sm:px-6">
            {{ $slot }}
        </main>

        @livewireScripts
        @fluxScripts
    </body>
</html>
