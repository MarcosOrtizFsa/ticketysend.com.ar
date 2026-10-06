@props(['compact' => false])

<span {{ $attributes->class(['inline-flex items-center gap-3']) }}>
    <span class="relative grid size-10 shrink-0 place-items-center overflow-hidden rounded-xl bg-ink-900 text-white shadow-lg shadow-blue-950/15 dark:bg-brand-500">
        <span class="absolute -right-2 -top-2 size-5 rounded-full bg-accent-500"></span>
        <svg aria-hidden="true" viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 7.5A2.5 2.5 0 0 1 7.5 5h9A2.5 2.5 0 0 1 19 7.5v5a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 4v-4A2.5 2.5 0 0 1 4 12.5v-5Z" />
            <path d="M8 9h8M8 12h5" />
        </svg>
    </span>
    @unless ($compact)
        <span class="leading-tight">
            <span class="block text-base font-bold tracking-tight text-ink-900 dark:text-white">Tickets <span class="text-brand-600 dark:text-blue-400">&</span> Send</span>
            <span class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Centro de soporte</span>
        </span>
    @endunless
</span>
