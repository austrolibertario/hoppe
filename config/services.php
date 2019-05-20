<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    /////////////////////
    // Autenticações
    /////////////////////
    'github' => [
        'client_id'     => env('CLIENT_ID'),
        'client_secret' => env('CLIENT_SECRET'),
        'redirect'      => str_finish(env('APP_URL'), '/').'auth/callback?driver=github',
    ],
    'linkedin' => [
        'client_id'     => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect'      => str_finish(env('APP_URL'), '/').'auth/callback?driver=linkedin',
    ],
    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => str_finish(env('APP_URL'), '/').'auth/callback?driver=facebook',
    ],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => str_finish(env('APP_URL'), '/').'auth/callback?driver=google',
    ],
    'twitter' => [
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect'      => str_finish(env('APP_URL'), '/').'auth/callback?driver=twitter',
    ],
    'weixin' => [
        'client_id'     => env('WEIXIN_KEY'),
        'client_secret' => env('WEIXIN_SECRET'),
        'redirect'      => env('WEIXIN_REDIRECT_URI'),
        'auth_base_uri' => 'https://open.weixin.qq.com/connect/qrconnect',
    ],
    'gitlab' => [
        'client_id' => env('GITLAB_KEY'),
        'client_secret' => env('GITLAB_SECRET'),
        'redirect' => env('GITLAB_REDIRECT_URI')
    ],
    
    /////////////////////
    // FIM DAS Autenticações
    /////////////////////

    'baidu_translate' => [
        'appid' => env('BAIDU_TRANSLATE_APPID'),
        'key'   => env('BAIDU_TRANSLATE_KEY'),
    ],

    'bearychat' => [
        'hook' => env('BEARYCHAT_HOOK'),
    ],
];
