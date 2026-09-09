<?php

return [
    'default' => env('LDAP_CONNECTION', 'default'),

    'connections' => [
        'default' => [
            'hosts' => array_filter(explode(',', (string) env('LDAP_HOST', '127.0.0.1'))),
            'username' => env('LDAP_USERNAME'),
            'password' => env('LDAP_PASSWORD'),
            'port' => (int) env('LDAP_PORT', 389),
            'base_dn' => env('LDAP_BASE_DN'),
            'timeout' => (int) env('LDAP_TIMEOUT', 5),
            'use_tls' => (bool) env('LDAP_TLS', env('LDAP_SSL', false)),
            'use_starttls' => (bool) env('LDAP_STARTTLS', false),
            'use_sasl' => (bool) env('LDAP_SASL', false),
            'options' => [],
        ],
    ],
];