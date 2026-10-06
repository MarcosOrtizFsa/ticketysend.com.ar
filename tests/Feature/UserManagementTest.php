<?php

namespace Tests\Feature;

use App\Livewire\Users\Index;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_an_admin_can_change_another_users_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $user = User::factory()->create();
        $user->assignRole('usuario');

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->call('updateRole', $user->id, 'supervisor')
            ->assertHasNoErrors();

        $this->assertTrue($user->fresh()->hasRole('supervisor'));
        $this->assertFalse($user->fresh()->hasRole('usuario'));
    }

    public function test_an_admin_cannot_change_their_own_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Index::class)
            ->call('updateRole', $admin->id, 'usuario')
            ->assertHasErrors("role.$admin->id");

        $this->assertTrue($admin->fresh()->hasRole('admin'));
    }

    public function test_non_admin_users_cannot_access_user_management(): void
    {
        foreach (['supervisor', 'usuario'] as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);

            $this->actingAs($user)->get(route('users.index'))->assertForbidden();
        }
    }
}
