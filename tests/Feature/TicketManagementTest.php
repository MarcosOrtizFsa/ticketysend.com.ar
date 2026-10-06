<?php

namespace Tests\Feature;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Livewire\Tickets\Create;
use App\Livewire\Tickets\Edit;
use App\Livewire\Tickets\Index;
use App\Livewire\Tickets\Show;
use App\Mail\TicketClosedMail;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketUpdatedMail;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class TicketManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
        Mail::fake();
    }

    public function test_a_regular_user_can_create_a_ticket_and_receives_a_queued_email(): void
    {
        $user = User::factory()->create();
        $user->assignRole('usuario');

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('form.subject', 'Error al ingresar al campus')
            ->set('form.description', 'El sistema muestra un error al intentar ingresar.')
            ->set('form.priority', TicketPriority::High->value)
            ->call('save')
            ->assertHasNoErrors();

        $ticket = Ticket::firstOrFail();
        $this->assertSame($user->id, $ticket->user_id);
        $this->assertSame(TicketStatus::Open, $ticket->status);
        $this->assertSame('TKT-000001', $ticket->reference);
        Mail::assertQueued(TicketCreatedMail::class, fn ($mail) => $mail->hasTo($user->email));
    }

    public function test_a_regular_user_only_sees_their_own_tickets(): void
    {
        $user = User::factory()->create();
        $user->assignRole('usuario');
        $own = Ticket::factory()->for($user, 'creator')->create(['subject' => 'Ticket propio']);
        $other = Ticket::factory()->create(['subject' => 'Ticket ajeno']);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->assertSee($own->subject)
            ->assertDontSee($other->subject);
    }

    public function test_a_supervisor_can_update_a_ticket_and_queue_an_email(): void
    {
        $supervisor = User::factory()->create();
        $supervisor->assignRole('supervisor');
        $ticket = Ticket::factory()->create();

        Livewire::actingAs($supervisor)
            ->test(Edit::class, ['ticket' => $ticket])
            ->set('form.subject', 'Asunto actualizado')
            ->set('form.description', 'Descripción suficientemente extensa.')
            ->set('form.priority', TicketPriority::High->value)
            ->set('form.status', TicketStatus::InProgress->value)
            ->call('save')
            ->assertHasNoErrors();

        $ticket->refresh();
        $this->assertSame('Asunto actualizado', $ticket->subject);
        $this->assertSame(TicketStatus::InProgress, $ticket->status);
        Mail::assertQueued(TicketUpdatedMail::class);
    }

    public function test_a_supervisor_can_close_a_ticket_with_audit_data(): void
    {
        $supervisor = User::factory()->create();
        $supervisor->assignRole('supervisor');
        $ticket = Ticket::factory()->create();

        Livewire::actingAs($supervisor)
            ->test(Show::class, ['ticket' => $ticket])
            ->call('close')
            ->assertHasNoErrors();

        $ticket->refresh();
        $this->assertSame(TicketStatus::Closed, $ticket->status);
        $this->assertSame($supervisor->id, $ticket->closed_by);
        $this->assertNotNull($ticket->closed_at);
        Mail::assertQueued(TicketClosedMail::class);
    }

    public function test_a_regular_user_cannot_update_or_close_a_ticket(): void
    {
        $user = User::factory()->create();
        $user->assignRole('usuario');
        $ticket = Ticket::factory()->for($user, 'creator')->create();

        $this->actingAs($user)->get(route('tickets.edit', $ticket))->assertForbidden();

        Livewire::actingAs($user)
            ->test(Show::class, ['ticket' => $ticket])
            ->call('close')
            ->assertForbidden();

        $this->assertSame(TicketStatus::Open, $ticket->fresh()->status);
        Mail::assertNothingQueued();
    }

    public function test_a_closed_ticket_cannot_be_edited_or_closed_again(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $ticket = Ticket::factory()->create([
            'status' => TicketStatus::Closed,
            'closed_by' => $admin,
            'closed_at' => now(),
        ]);

        $this->actingAs($admin)->get(route('tickets.edit', $ticket))->assertForbidden();
        $this->assertFalse($admin->can('close', $ticket));
    }

    public function test_ticket_email_templates_render_the_ticket_reference(): void
    {
        $closer = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'status' => TicketStatus::Closed,
            'closed_by' => $closer,
            'closed_at' => now(),
        ])->load(['creator', 'closedBy']);

        foreach ([
            new TicketCreatedMail($ticket),
            new TicketUpdatedMail($ticket),
            new TicketClosedMail($ticket),
        ] as $mail) {
            $this->assertStringContainsString($ticket->reference, $mail->render());
        }
    }
}
