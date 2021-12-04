<?php

return [
    'title'                 => 'Vereisten',

    'next'                  => 'Volgende',
    'refresh'               => 'Verversen',

    'steps' => [
        'requirements'      => 'Vraag a.u.b. uw hostingprovider om de fouten op te lossen',
        'language'          => 'Stap 1/3 : Taal selecteren',
        'database'          => 'Stap 2/3 : Database aanmaken',
        'settings'          => 'Stap 3/3 : Bedrijfs- en admin-details',
    ],

    'language' => [
        'select'            => 'Selecteer taal',
    ],

    'requirements' => [
        'enabled'           => ':feature moet worden aangezet!',
        'disabled'          => ':feature moet worden uitgezet!',
        'extension'         => ':extension extensie moet worden geïnstalleerd en geladen.',
        'directory'         => ':directory map moet schrijfbaar zijn!',
    ],

    'database' => [
        'hostname'          => 'Hostnaam',
        'username'          => 'Gebruikersnaam',
        'password'          => 'Wachtwoord',
        'name'              => 'Database',
    ],

    'settings' => [
        'company_name'      => 'Bedrijfsnaam',
        'company_email'     => 'E-mail bedrijf',
        'admin_email'       => 'E-mail admin',
        'admin_name'        => 'Naam admin',
        'admin_password'    => 'Wachtwoord admin',
    ],

    'error' => [
        'connection'        => 'Error: Kan niet verbinden met de database! Controleer alstublieft of de gegevens kloppen.',
    ],

];
