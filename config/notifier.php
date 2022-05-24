<?php

return array(

    'client' => [
        /**
         * Server URL
         */
        'url' => env('NOTIFIER_URL'),

        /**
         * HTTP client timeout
         */
        'timeout'    => env('NOTIFIER_TIMEOUT', 15),

        /**
         * Custom HTTP headers
         */
        'headers'    => [],

        /**
         * Username for authentication
         */
        'username' => env('NOTIFIER_BASE_AUTH_USERNAME'),
        'password' => env('NOTIFIER_BASE_AUTH_PASSWORD'),

        /**
         * Enable debug output to the php error log
         */
        'debug' => env('NOTIFIER_DEBUG', true),

        /**
         * SSL certificates verification
         */
        'ssl_verify_peer' => env('NOTIFIER_SSL', true),

        /**
         * Methods to Cache
         * '*' to allow all, and 'method_name' to single method
         */
        'cache' => env('NOTIFIER_CACHE', '*'),

        'cache_duration' => env('NOTIFIER_CACHE_TIME', 15),
    ],

    'server' => [
    ],
);
