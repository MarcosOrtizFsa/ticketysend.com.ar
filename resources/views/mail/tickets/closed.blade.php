<x-mail::message>
# Ticket cerrado

Tu ticket **{{ $ticket->reference }}** fue cerrado por {{ $ticket->closedBy?->name }}.

**Asunto:** {{ $ticket->subject }}  
**Fecha de cierre:** {{ $ticket->closed_at?->format('d/m/Y H:i') }}

<x-mail::button :url="route('tickets.show', $ticket)">Ver ticket</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
