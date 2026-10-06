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
        <main class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(28rem,0.72fr)]">
            <aside class="relative hidden overflow-hidden bg-ink-900 p-12 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="absolute -left-24 -top-24 size-96 rounded-full bg-brand-500/20 blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 size-80 rounded-full bg-accent-500/20 blur-3xl"></div>
                <x-brand class="relative [&_span_span]:!text-white" />
                <div class="relative max-w-xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-blue-300">Programación IV</p>
                    <h1 class="mt-5 text-5xl font-bold leading-[1.08] tracking-tight">Cada consulta,<br><span class="text-blue-300">en el lugar correcto.</span></h1>
                    <p class="mt-6 max-w-lg text-lg leading-8 text-slate-300">Registrá solicitudes, seguí su avance y mantené cada respuesta organizada desde un único espacio.</p>
                </div>
                <p class="relative text-sm text-slate-400">Seguro · Trazable · Simple</p>
            </aside>

            <section class="flex min-h-screen items-center px-4 py-10 sm:px-8 lg:px-14">
                <div class="mx-auto w-full max-w-md">
                    <a href="/" class="mb-8 inline-flex lg:hidden"><x-brand /></a>
                    <div class="surface-card p-6 sm:p-8">
                {{ $slot }}
                    </div>
                    <p class="mt-6 text-center text-xs text-slate-500">Tus credenciales se transmiten de forma segura.</p>
                </div>
            </section>
        </main>
        @livewireScripts
        @fluxScripts
    </body>
</html>
