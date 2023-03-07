<x-mail::message>
    # Beste {{$member->getName()}},

    Uw account voor {{config('app.name')}} is geactiveerd. Om toegang te krijgen dient u alleen nog een wachtwoord aan te maken.

    <x-mail::button :url="$activationUrl">
        Wachtwoord instellen
    </x-mail::button>

    Met vriendelijke groet,<br>

    {{config('app.name')}}
</x-mail::message>


