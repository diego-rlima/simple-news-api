<?php

namespace App\Domains\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Account\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 9)->create();
    }

    public static function registerDefaultAdmin()
    {
        User::create([
            'name' => env('DEFAULT_ADMIN_NAME'),
            'email' => env('DEFAULT_ADMIN_EMAIL'),
            'password' => env('DEFAULT_ADMIN_PASSWORD'),
            'role' => 'administrator',
        ]);
    }
}
