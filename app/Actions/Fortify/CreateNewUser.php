<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        $input['email'] = Str::lower(trim($input['email'] ?? ''));

        Validator::make($input, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'string',
                app()->environment('testing') ? 'email:rfc' : 'email:rfc,dns',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresá un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ])->validate();

        $role = Role::query()
            ->where('name', 'usuario')
            ->where('guard_name', 'web')
            ->first();

        if (! $role) {
            throw ValidationException::withMessages([
                'email' => 'El registro no está disponible porque falta la configuración de roles.',
            ]);
        }

        return DB::transaction(function () use ($input, $role): User {
            $user = User::create([
                'name' => trim($input['name']),
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // El rol público nunca se toma del formulario: se impone desde el servidor.
            $user->syncRoles([$role]);

            return $user;
        });
    }
}
