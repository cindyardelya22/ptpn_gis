<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'ml' => [
        'url'   => env('ML_SERVICE_URL', 'http://127.0.0.1:5000'),
        'debug' => env('ML_DEBUG_MODE', false),

        // Unit conversion factors: DB value × factor = value sent to model
        // Default 1 = no conversion (send raw DB values)
        'conversions' => [
            'N'  => (float) env('ML_CONVERT_N', 1),
            'P'  => (float) env('ML_CONVERT_P', 1),
            'K'  => (float) env('ML_CONVERT_K', 1),
            'pH' => (float) env('ML_CONVERT_PH', 1),
            'EC' => (float) env('ML_CONVERT_EC', 1),
            'OC' => (float) env('ML_CONVERT_OC', 1),
            'S'  => (float) env('ML_CONVERT_S', 1),
            'Mg' => (float) env('ML_CONVERT_MG', 1),
            'B'  => (float) env('ML_CONVERT_B', 1),
        ],
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
    ],

];
