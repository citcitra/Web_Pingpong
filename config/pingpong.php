<?php

return [
    // Raspberry Pi API address on the same trusted LAN, e.g. http://192.168.1.50:5000
    'raspberry_url' => env('RASPBERRY_PI_URL', ''),
    // Must match the Raspberry Pi service's secret. Keep this in .env only.
    'raspberry_token' => env('RASPBERRY_PI_TOKEN', ''),
    'request_timeout' => (int) env('RASPBERRY_PI_TIMEOUT', 3),
];
