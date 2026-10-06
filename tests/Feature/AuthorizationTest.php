<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_role_permission_matrix_is_correct(): void
    {
        $matrix = [
            'admin' => [true, true, true, true, true],
            'supervisor' => [true, true, true, true, false],
            'usuario' => [true, true, false, false, false],
        ];
        $permissions = [
            'crear tickets',
            'ver tickets',
            'editar tickets',
            'cerrar tickets',
            'gestionar usuarios',
        ];

        foreach ($matrix as $role => $expected) {
            $user = User::factory()->create();
            $user->assignRole($role);

            foreach ($permissions as $index => $permission) {
                $this->assertSame($expected[$index], $user->can($permission), "$role / $permission");
            }
        }
    }

    public function test_regular_user_cannot_view_another_users_ticket(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('usuario');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('usuario');
        $ticket = Ticket::factory()->for($owner, 'creator')->create();

        $this->assertTrue(Gate::forUser($owner)->allows('view', $ticket));
        $this->assertFalse(Gate::forUser($otherUser)->allows('view', $ticket));
    }

    public function test_admin_and_supervisor_can_view_and_modify_any_ticket(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('usuario');
        $ticket = Ticket::factory()->for($owner, 'creator')->create();

        foreach (['admin', 'supervisor'] as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);

            $this->assertTrue(Gate::forUser($user)->allows('view', $ticket));
            $this->assertTrue(Gate::forUser($user)->allows('update', $ticket));
            $this->assertTrue(Gate::forUser($user)->allows('close', $ticket));
        }
    }
}
