<x-mail::message>
# Beste {{$member->getName()}},

Uw account voor {{config('app.name')}} is geactiveerd. Om toegang te krijgen dient u alleen nog een wachtwoord aan te maken.

<x-mail::button :url="$activationUrl">
    Wachtwoord instellen
</x-mail::button>

Werkt de knop niet, kopieer dan de volgende url naar de browser:
{{ $activationUrl }}

Met vriendelijke groet,<br>

{{config('app.name')}}
</x-mail::message>


