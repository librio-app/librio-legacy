<x-mail::message>
# @lang('mail.greeting') {{$member->getName()}},

Uw account voor {{config('app.name')}} is geactiveerd. Om toegang te krijgen dient u alleen nog een wachtwoord aan te maken.
Let op! De activatielink is 1 week geldig.

<x-mail::button :url="$activationUrl">
    Wachtwoord instellen
</x-mail::button>

@lang('mail.regards'),<br>

{{config('app.name')}}

@component('mail::subcopy')
    @lang('mail.trouble', ['actionText' => 'Wachtwoord instellen']) <span class="break-all">[{{ $activationUrl }}]({{ $activationUrl }})</span>
@endcomponent

</x-mail::message>


