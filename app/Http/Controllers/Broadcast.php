<?php

namespace App\Http\Controllers;

use Pusher\Pusher;

class Broadcast extends Controller
{
    public $data;

    public $channel;

    public $event;

    public function push()
    {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true,
        ];
        $pusher = new Pusher(
            'a3987808aa6ec6b509f6',
            '19df31ebfd0f751bbd7a',
            '1160464',
            $options
        );

        $data = json_encode($this->data);
        $pusher->trigger($this->channel, $this->event, $data);
    }
}
