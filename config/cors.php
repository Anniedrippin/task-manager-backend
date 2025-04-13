<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | This file controls how your application handles cross-origin resource
    | sharing or "CORS". You may adjust these settings as needed to
    | fit the requirements of your frontend or API consumers.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Routes that will have CORS enabled

    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, etc.)

    'allowed_origins' => ['*'], // Allow all origins (change this for production!)

    'allowed_origins_patterns' => [], // Use regex patterns to match allowed origins

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [], // Headers that are accessible to the frontend

    'max_age' => 0, // How long the response should be cached (in seconds)

    'supports_credentials' => false, // Set to true if your frontend sends cookies/auth headers

];
