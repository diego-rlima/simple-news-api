<?php

return [
    // Domains
    'job' => '{root}\Domains\{prefix|required}\Jobs',
    'model' => '{root}\Domains\{prefix|required}\Models',
    'policy' => '{root}\Domains\{prefix|required}\Policies',
    'resource' => '{root}\Domains\{prefix|required}\Resources',
    'notification' => '{root}\Domains\{prefix|required}\Notifications',
    'migration' => '{root}/Domains/{prefix|required}/Database/Migrations',
    'seeder' => '{root}/Domains/{prefix|required}/Database/Seeds/{name}.php',
    'factory' => '{root}/Domains/{prefix|required}/Database/Factories/{name}.php',

    // Units
    'mail' => '{root}\Units\{prefix|required}\Mail',
    'request' => '{root}\Units\{prefix|required}\Http\Requests',
    'middleware' => '{root}\Units\{prefix|required}\Middleware',
    'command' => '{root}\Units\{prefix|required}\Commands',
    'controller' => '{root}\Units\{prefix|required}\Http\Controllers',
    'channel' => '{root}\Units\{prefix|required}\Broadcasting',

    // General
    'event' => '{root}\{prefix|required}\Events',
    'rule' => '{root}\Support\Rules\{suffix}',
    'test' => '{root}\{prefix}\{type}\{suffix}',
    'provider' => '{root}\{prefix|required}\Providers',
    'listener' => '{root}\{prefix|required}\Listeners',
    'exception' => '{root}\{prefix|required}\Exceptions',
];
