<x-mail::message>
# Ticket actualizado

Tu ticket **{{ $ticket->reference }}** fue actualizado.

**Asunto:** {{ $ticket->subject }}  
**Prioridad:** {{ $ticket->priority->label() }}  
**Estado:** {{ $ticket->status->label() }}

<x-mail::button :url="route('tickets.show', $ticket)">Ver ticket</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
