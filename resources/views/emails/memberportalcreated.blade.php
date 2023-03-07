@component('mail::message')
    # Beste {{$member->getName()}},

    Uw account voor {{config('app.name')}} is geactiveerd. Om toegang te krijgen dient u alleen nog een wachtwoord aan te maken.

    @component('mail::button', ['url' => $$activationUrl])
        Wachtwoord instellen
    @endcomponent

    Werkt de knop niet? Kopieer dan de volgende link naar uw browser: {{$url}}


    Met vriendelijke groet,

    {{config('app.name')}}
@endcomponent
