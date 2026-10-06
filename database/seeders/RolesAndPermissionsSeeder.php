<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = collect([
            'crear tickets',
            'ver tickets',
            'editar tickets',
            'cerrar tickets',
            'gestionar usuarios',
        ])->mapWithKeys(fn (string $name) => [
            $name => Permission::findOrCreate($name, 'web'),
        ]);

        Role::findOrCreate('admin', 'web')->syncPermissions($permissions->values());
        Role::findOrCreate('supervisor', 'web')->syncPermissions($permissions->only([
            'crear tickets', 'ver tickets', 'editar tickets', 'cerrar tickets',
        ])->values());
        Role::findOrCreate('usuario', 'web')->syncPermissions($permissions->only([
            'crear tickets', 'ver tickets',
        ])->values());

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
