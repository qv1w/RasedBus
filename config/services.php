<?php

return [
    // ... existing services

    'bus_system' => [
        'max_students_per_bus' => env('MAX_STUDENTS_PER_BUS', 50),
        'default_payment_amount' => env('DEFAULT_PAYMENT_AMOUNT', 500),
        'enable_notifications' => env('ENABLE_NOTIFICATIONS', true),
    ],
];