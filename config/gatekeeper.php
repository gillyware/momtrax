<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Gatekeeper will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => 'gatekeeper',

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | Specifies which timezone to use for displaying datetimes on the dashboard.
    |
    */

    'timezone' => 'America/New_York',

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Determines which Gatekeeper features are enabled.
    |
    */

    'features' => [
        'audit' => [
            'enabled' => true,
        ],
        'roles' => [
            'enabled' => false,
        ],
        'features' => [
            'enabled' => true,
        ],
        'teams' => [
            'enabled' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Defines the database table names used by Gatekeeper. These may be
    | customized to align with existing schemas or naming patterns.
    |
    */

    'tables' => [
        'permissions' => 'permissions',
        'roles' => 'roles',
        'features' => 'features',
        'teams' => 'teams',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'model_has_features' => 'model_has_features',
        'model_has_teams' => 'model_has_teams',
        'audit_log' => 'gatekeeper_audit_log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Configure the cache behavior for Gatekeeper. This includes the cache
    | prefix, TTL (in seconds), and optional priming behavior for model
    | access maps when a model's cache is invalidated.
    |
    */

    'cache' => [
        'enabled' => env('GATEKEEPER_CACHE_ENABLED', true),
        'prefix' => env('GATEKEEPER_CACHE_PREFIX', 'gatekeeper'),
        'ttl' => env('GATEKEEPER_CACHE_TTL', 365 * 24 * 60 * 60),
        'prime_model_access' => [
            'enabled' => env('GATEKEEPER_CACHE_PRIME_MODEL_ACCESS_ENABLED', true),
            'async' => env('GATEKEEPER_CACHE_PRIME_MODEL_ACCESS_ASYNC', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Defines the models available to Gatekeeper. Each entry contains the
    | attributes to identify, search, and display the model using Gatekeeper.
    |
    */

    'models' => [

        'manageable' => [

            'user' => [
                'label' => 'User',
                'class' => App\Models\User::class,
                'searchable' => [
                    ['column' => 'id', 'label' => 'ID'],
                    ['column' => 'first_name', 'label' => 'first name'],
                    ['column' => 'last_name', 'label' => 'last name'],
                    ['column' => 'nickname', 'label' => 'nickname'],
                    ['column' => 'email', 'label' => 'email'],
                ],
                'displayable' => [
                    ['column' => 'id', 'label' => 'ID', 'cli_width' => 10],
                    ['column' => 'nickname', 'label' => 'Nickname', 'cli_width' => 25],
                    ['column' => 'email', 'label' => 'Email', 'cli_width' => 35],
                ],
            ],

            'feature' => [
                'label' => 'Feature',
                'class' => Gillyware\Gatekeeper\Models\Feature::class,
                'searchable' => [
                    ['column' => 'name', 'label' => 'name'],
                ],
                'displayable' => [
                    ['column' => 'name', 'label' => 'Name', 'cli_width' => 20],
                    ['column' => 'grant_by_default', 'label' => 'On By Default', 'cli_width' => 20],
                    ['column' => 'is_active', 'label' => 'Active', 'cli_width' => 15],
                ],
            ],

        ],

    ],

];
