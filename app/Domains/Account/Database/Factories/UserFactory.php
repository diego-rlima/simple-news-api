<?php

namespace App\Domains\Account\Database\Factories;

use App\Domains\Account\Models\User;
use App\Support\Domains\Database\Factory;

class UserFactory extends Factory
{
    /**
     * Factory for the User Model.
     *
     * @var User
     */
    protected $model = User::class;

    /**
     * Array with all fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'email_verified_at' => now(),
            'remember_token' => str_random(10),
        ];
    }
}
