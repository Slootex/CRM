<?php

namespace App\Broadcasting;

use App\Models\User;

class test
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @return array|bool
     */
    public function join(User $user)
    {
        //
    }
}