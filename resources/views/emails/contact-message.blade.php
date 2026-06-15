<x-mail::message>
# Nieuw bericht via het contactformulier

Je hebt een nieuw bericht ontvangen via de AnimaShop website.

**Naam:** {{ $name }}  
**E-mail:** {{ $email }}

**Bericht:**
<x-mail::panel>
{{ $messageContent }}
</x-mail::panel>

Je kunt direct antwoorden op deze e-mail om terug te mailen naar de klant.

Met vriendelijke groet,<br>
{{ config('app.name') }} Systeem
</x-mail::message>
