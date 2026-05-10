<?php

return [
    'currency' => [
        'EUR' => 'EUR',
        'USD' => 'USD',
    ],

    'salutation' => [
        'man' => 'man',
        'female' => 'female',
        'family' => 'family',
    ],

    'payment_period' => [
        'per-book-daily' => 'per-book-daily',
        'weekly' => 'weekly',
        'monthly' => 'monthly',
        'yearly' => 'yearly',
    ],

    'expire_date' => [
        '1-week' => '1-week', // P7D
        '1-month' => '1-month', // P1M
        '3-months' => '3-months', // P3M
        'half-year' => 'half-year', // P6M
        'year' => 'year', // P1Y
        '2-years' => '2-years', // P2Y
        'ongoing' => 'ongoing', // P100Y
    ],

    'expire_date_format' => [
        '1-week' => 'P7D',
        '1-month' => 'P1M',
        '3-months' => 'P3M',
        'half-year' => 'P6M',
        'year' => 'P1Y',
        '2-years' => 'P2Y',
        'ongoing' => 'P100Y',
    ],

    'barcode_status' => [
        'new' => 'new',
        'ordered' => 'ordered',
        'in_repair' => 'in_repair',
        'lost' => 'lost',
        'taken_in' => 'taken_in',
        'lended' => 'lended',
        'available' => 'available',
        'deleted' => 'deleted',
    ]
];
