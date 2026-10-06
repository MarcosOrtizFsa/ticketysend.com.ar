<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tickets', function () {
        Gate::authorize('viewAny', Ticket::class);

        return view('tickets.index');
    })->name('tickets.index');

    Route::get('/tickets/create', function () {
        Gate::authorize('create', Ticket::class);

        return view('tickets.create');
    })->name('tickets.create');

    Route::get('/tickets/{ticket}', function (Ticket $ticket) {
        Gate::authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    })->name('tickets.show');

    Route::get('/tickets/{ticket}/edit', function (Ticket $ticket) {
        Gate::authorize('update', $ticket);

        return view('tickets.edit', compact('ticket'));
    })->name('tickets.edit');

    Route::view('/users', 'users.index')
        ->middleware('can:gestionar usuarios')
        ->name('users.index');
});
