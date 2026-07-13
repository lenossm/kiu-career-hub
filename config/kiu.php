<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public demo logins (login page quick-access buttons)
    |--------------------------------------------------------------------------
    | Turn off on production if you don't want one-click test accounts.
    */
    'demo_logins_enabled' => env('DEMO_LOGINS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Allow "Career Office" role on registration form
    |--------------------------------------------------------------------------
    | We keep this false on the live demo so random visitors can't become admin.
    */
    'allow_admin_register' => env('ALLOW_ADMIN_REGISTER', false),

];
