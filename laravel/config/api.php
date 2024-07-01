<?php

use App\Api\Methods\ConvertApiMethod;
use App\Api\Methods\RatesApiMethod;

return [
    'get' => [
        'rates' => RatesApiMethod::class,
    ],
    'post' => [
        'convert' => ConvertApiMethod::class,
    ],
];
