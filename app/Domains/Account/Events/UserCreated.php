<?php

namespace App\Domains\Account\Events;

use App\Domains\Account\Models\User;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use SerializesModels;

    /**
     * Created user.
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
