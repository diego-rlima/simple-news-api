<?php

namespace App\Domains\Account\Events;

use App\Domains\Account\Models\User;
use Illuminate\Queue\SerializesModels;

class UserUpdated
{
    use SerializesModels;

    /**
     * Updated user.
     *
     * @var \App\Domains\Account\Models\User
     */
    protected $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Domains\Account\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
