<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        $user = auth()->user();

        return view('livewire.dashboard', [
            'user' => $user,
            'role' => match ($user->getRoleNames()->first()) {
                'admin' => 'Administrador',
                'supervisor' => 'Supervisor',
                'usuario' => 'Usuario',
                default => 'Sin rol',
            },
            'permissions' => $user->getAllPermissions()->pluck('name')->sort()->values(),
        ]);
    }
}
