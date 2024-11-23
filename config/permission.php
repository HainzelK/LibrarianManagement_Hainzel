<?php

return [

    'models' => [

        /*
         * Custom models for permissions and roles.
         * Update these if you want to use custom models for your roles and permissions.
         * Make sure the models implement the required contracts.
         */

        'permission' => App\Models\Permission::class, // Custom Permission model
        'role' => App\Models\Role::class, // Custom Role model

    ],

    'table_names' => [

        /*
         * Default table names for Spatie's role and permission system.
         * Change these if you need to customize your database structure.
         */

        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Customize the related pivots or primary keys, if necessary.
         * For example, change `model_id` to `model_uuid` if your app uses UUIDs.
         */

        'role_pivot_key' => null, // default 'role_id',
        'permission_pivot_key' => null, // default 'permission_id',
        'model_morph_key' => 'model_id',
        'team_foreign_key' => 'team_id',
    ],

    /*
     * Enable or disable registering the method for checking permissions in the gate.
     */

    'register_permission_check_method' => true,

    /*
     * Octane reset listener for refreshing permissions.
     */

    'register_octane_reset_listener' => false,

    /*
     * Teams Feature:
     * Set to true if you want to implement team-based permissions.
     */

    'teams' => false,

    /*
     * Passport Client Credentials Grant:
     * Enable this if you're using Laravel Passport for API authentication.
     */

    'use_passport_client_credentials' => false,

    /*
     * Security settings:
     * Add permission/role names to exception messages. Disabled by default for security.
     */

    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,

    /*
     * Enable wildcard permissions.
     * Useful for dynamic permission matching.
     */

    'enable_wildcard_permission' => false,

    /*
     * Cache configuration:
     * Customize expiration times and cache drivers for improved performance.
     */

    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
