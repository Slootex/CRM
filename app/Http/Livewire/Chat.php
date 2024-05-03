<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Broadcast;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class Chat extends Component
{
    use WithFileUploads;

    public $message;

    public $channel;

    public $file;

    public function mount($channel)
    {
        $this->channel = $channel;
    }

    public function uuid($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function sendFile($username)
    {
        if ($this->file != null) {
            $filename = $this->uuid();
            $this->file->storeAs('team', $filename.'.png');
            $broadcast = new Broadcast();
            $broadcast->channel = $this->channel;
            $broadcast->event = 'neueNachricht';
            $broadcast->data = ['message' => "<a class='text-blue-400' target='_blank' href='http://localhost:8000/team/".$filename.".png'>".$filename.'.png</a>', 'username' => $username];
            $broadcast->push();
        }
    }

    public function sendMessage($username)
    {
        if ($this->message != null) {
            $broadcast = new Broadcast();
            $broadcast->channel = $this->channel;
            $broadcast->event = 'neueNachricht';
            $broadcast->data = ['message' => $this->message, 'username' => $username];
            $broadcast->push();
            $this->sendFile($username);
        }
    }

    public function render(Request $req)
    {
        return view('livewire.chat');
    }
}
