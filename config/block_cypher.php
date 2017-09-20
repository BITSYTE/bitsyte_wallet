<?php

return [

    'key' => env('APP_BLOCKCYPHER_TOKEN'),

    'chain' => env('APP_BLOCKCYPHER_ENV', 'test3'),

    'coin' => 'btc',

    'version' => 'v1',

    'config' => [

        'mode' => 'sandbox',

        'log.LogEnabled' => false,

        'log.FileName' => 'BlockCypher.log',

        'log.LogLevel' => 'DEBUG'

    ],
];