<?php

return [

    'key' => env('BLOCKCYPHER_TOKEN'),

    'chain' => env('BLOCKCYPHER_ENV', 'test3'),

    'coin' => 'btc',

    'version' => 'v1',

    'config' => [

        'mode' => 'sandbox',

        'log.LogEnabled' => true,

        'log.FileName' => 'BlockCypher.log',

        'log.LogLevel' => 'DEBUG'

    ],
];