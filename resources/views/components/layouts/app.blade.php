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
    <body class="app-background min-h-screen text-slate-900 antialiased dark:text-slate-100">
        <a href="#contenido" class="sr-only z-50 rounded-lg bg-white px-4 py-2 font-semibold text-brand-700 focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Saltar al contenido</a>
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/85">
            <nav aria-label="Navegación principal" class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-4 lg:gap-8">
                    <a href="{{ route('dashboard') }}" aria-label="Ir al inicio"><x-brand /></a>
                    @auth
                        <div class="hidden items-center gap-1 md:flex">
                            <a href="{{ route('dashboard') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('dashboard')]) @if(request()->routeIs('dashboard')) aria-current="page" @endif>Inicio</a>
                            <a href="{{ route('tickets.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('tickets.*')]) @if(request()->routeIs('tickets.*')) aria-current="page" @endif>Tickets</a>
                            @can('gestionar usuarios')
                                <a href="{{ route('users.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('users.*')]) @if(request()->routeIs('users.*')) aria-current="page" @endif>Usuarios</a>
                            @endcan
                        </div>
                    @endauth
                </div>
                @auth
                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="max-w-40 truncate text-sm font-semibold text-ink-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="max-w-40 truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <span aria-hidden="true" class="grid size-9 place-items-center rounded-full bg-brand-100 text-sm font-bold text-brand-700 dark:bg-blue-950 dark:text-blue-200">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:button type="submit" variant="ghost">Salir</flux:button>
                        </form>
                    </div>
                    <div class="order-3 flex w-full gap-1 border-t border-slate-100 pt-3 md:hidden dark:border-slate-800">
                        <a href="{{ route('dashboard') }}" @class(['nav-link flex-1 text-center', 'nav-link-active' => request()->routeIs('dashboard')])>Inicio</a>
                        <a href="{{ route('tickets.index') }}" @class(['nav-link flex-1 text-center', 'nav-link-active' => request()->routeIs('tickets.*')])>Tickets</a>
                        @can('gestionar usuarios')
                            <a href="{{ route('users.index') }}" @class(['nav-link flex-1 text-center', 'nav-link-active' => request()->routeIs('users.*')])>Usuarios</a>
                        @endcan
                    </div>
                @endauth
            </nav>
        </header>

        <main id="contenido" class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            @if (session('status'))
                <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200">
                    <span aria-hidden="true" class="mt-0.5 grid size-5 place-items-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</span>
                    {{ session('status') }}
                </div>
            @endif
            {{ $slot }}
        </main>

        @livewireScripts
        @fluxScripts
        <footer class="mx-auto max-w-7xl px-4 pb-8 text-center text-xs text-slate-500 sm:px-6 lg:px-8">{{ config('app.name') }} · Soporte organizado, respuestas claras.</footer>
    </body>
</html>
