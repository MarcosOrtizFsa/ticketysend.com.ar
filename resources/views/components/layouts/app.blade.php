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
            <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6">
                <div class="flex flex-wrap items-center gap-5">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
                    @auth
                        <a href="{{ route('tickets.index') }}" class="text-sm text-zinc-600 hover:text-zinc-950 dark:text-zinc-300 dark:hover:text-white">Tickets</a>
                        @can('gestionar usuarios')
                            <a href="{{ route('users.index') }}" class="text-sm text-zinc-600 hover:text-zinc-950 dark:text-zinc-300 dark:hover:text-white">Usuarios</a>
                        @endcan
                    @endauth
                </div>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:button type="submit" variant="ghost">Cerrar sesión</flux:button>
                    </form>
                @endauth
            </nav>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-10 sm:px-6">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif
            {{ $slot }}
        </main>

        @livewireScripts
        @fluxScripts
    </body>
</html>
