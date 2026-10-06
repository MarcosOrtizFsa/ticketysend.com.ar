<?php

namespace App\Livewire\Forms;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TicketForm extends Form
{
    public string $subject = '';

    public string $description = '';

    public string $priority = 'medium';

    public string $status = 'open';

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:10'],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'status' => ['required', Rule::in([
                TicketStatus::Open->value,
                TicketStatus::InProgress->value,
            ])],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'El asunto es obligatorio.',
            'subject.max' => 'El asunto no puede superar los 200 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.min' => 'La descripción debe tener al menos 10 caracteres.',
            'priority.required' => 'Seleccioná una prioridad.',
            'priority.enum' => 'La prioridad seleccionada no es válida.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }

    public function fillFrom(Ticket $ticket): void
    {
        $this->subject = $ticket->subject;
        $this->description = $ticket->description;
        $this->priority = $ticket->priority->value;
        $this->status = $ticket->status->value;
    }
}
