@component('mail::message')
    # Beste {{$member->getName()}},

    Uw account voor {{config('app.name')}} is geactiveerd.

    Klik <a href="{{ $link }}">hier</a> om uw account te activeren.
    Werkt de link niet, kopieer dan de volgende url naar je browser:
    {{ $link }}


    Met vriendelijke groet,

    {{config('app.name')}}
@endcomponent
