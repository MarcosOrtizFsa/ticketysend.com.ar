<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_a_guest_can_register_with_the_user_role(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'María Pérez',
            'email' => '  MARIA@example.com ',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::where('email', 'maria@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('Password123!', $user->password));
        $this->assertSame(['usuario'], $user->getRoleNames()->all());
    }

    public function test_registration_rejects_a_duplicate_email(): void
    {
        User::factory()->create(['email' => 'usuario@example.com']);

        $this->post(route('register.store'), [
            'name' => 'Otra persona',
            'email' => 'USUARIO@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertSessionHasErrors('email');

        $this->assertSame(1, User::count());
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $this->post(route('register.store'), [
            'name' => 'María Pérez',
            'email' => 'maria@example.com',
            'password' => 'Password123!',
        ])->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'maria@example.com']);
    }

    public function test_registration_cannot_be_manipulated_to_obtain_admin_role(): void
    {
        $this->post(route('register.store'), [
            'name' => 'María Pérez',
            'email' => 'maria@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'admin',
            'permissions' => ['gestionar usuarios'],
        ])->assertRedirect('/dashboard');

        $user = User::where('email', 'maria@example.com')->firstOrFail();
        $this->assertSame(['usuario'], $user->getRoleNames()->all());
        $this->assertFalse($user->can('gestionar usuarios'));
    }

    public function test_registration_fails_without_the_configured_user_role(): void
    {
        Role::findByName('usuario')->delete();

        $this->post(route('register.store'), [
            'name' => 'María Pérez',
            'email' => 'maria@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', ['email' => 'maria@example.com']);
    }

    public function test_a_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);
        $user->assignRole('usuario');

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_authentication_views_render_successfully(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Iniciar sesión');
        $this->get(route('register'))->assertOk()->assertSee('Crear cuenta');

        $user = User::factory()->create();
        $user->assignRole('usuario');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Usuario');
    }
}
