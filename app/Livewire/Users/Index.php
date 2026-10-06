<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updateRole(int $userId, string $role): void
    {
        Gate::authorize('gestionar usuarios');
        validator(['role' => $role], [
            'role' => ['required', Rule::in(['admin', 'supervisor', 'usuario'])],
        ])->validate();

        $user = User::findOrFail($userId);

        if ($user->is(auth()->user())) {
            $this->addError("role.$userId", 'No podés modificar tu propio rol.');

            return;
        }

        if ($user->hasRole('admin') && $role !== 'admin' && User::role('admin')->count() === 1) {
            $this->addError("role.$userId", 'Debe existir al menos un administrador.');

            return;
        }

        $user->syncRoles([$role]);
        session()->flash('status', "El rol de {$user->name} fue actualizado.");
    }

    public function render(): View
    {
        Gate::authorize('gestionar usuarios');

        return view('livewire.users.index', [
            'users' => User::query()
                ->with('roles')
                ->when($this->search !== '', fn ($query) => $query
                    ->where(fn ($query) => $query
                        ->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')))
                ->orderBy('name')
                ->paginate(10),
            'roles' => [
                'admin' => 'Administrador',
                'supervisor' => 'Supervisor',
                'usuario' => 'Usuario',
            ],
        ]);
    }
}
