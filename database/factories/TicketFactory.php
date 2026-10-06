<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Ticket> */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'priority' => TicketPriority::Medium,
            'status' => TicketStatus::Open,
            'user_id' => User::factory(),
            'closed_by' => null,
            'closed_at' => null,
        ];
    }
}
