@component('mail::message')
    # Beste {{$member->getName()}},

    Uw account voor {{config('app.name')}} is geactiveerd.

    Klik <a href="{{ $activationUrl }}">hier</a> om uw account te activeren.
    Werkt de link niet, kopieer dan de volgende url naar je browser:
    {{ $activationUrl }}


    Met vriendelijke groet,

    {{config('app.name')}}
@endcomponent
