<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;

    public $message;

    public function __construct($username)
    {
        $this->username = $username;
        $this->message  = "{$username} sent you a message";
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('sent-message'),
        ];
    }
}
