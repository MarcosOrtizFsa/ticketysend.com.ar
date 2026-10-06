<x-mail::message>
# Ticket recibido

Hola {{ $ticket->creator->name }}, registramos tu ticket **{{ $ticket->reference }}**.

**Asunto:** {{ $ticket->subject }}  
**Prioridad:** {{ $ticket->priority->label() }}  
**Estado:** {{ $ticket->status->label() }}

<x-mail::button :url="route('tickets.show', $ticket)">Ver ticket</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
