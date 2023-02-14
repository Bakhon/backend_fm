<?php

return [
    'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY'),
    'load_user_from_database' => env('KEYCLOAK_LOAD_USER_FROM_DATABASE', true),
    'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),
    'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),
    'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', false),
    'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES'),

    'realm_name' => env('KEYCLOAK_REALM_NAME'),
    'base_url' => env('KEYCLOAK_BASE_URL'),
    'grant_type' => env('KEYCLOAK_GRANT_TYPE'),
    'client_name' => env('KEYCLOAK_CLIENT_NAME'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
    'client_id' => env('KEYCLOAK_CLIENT_ID'),
];
