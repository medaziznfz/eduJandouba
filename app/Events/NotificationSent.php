<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $title;
    public $subtitle;
    public $redirectLink;

    public function __construct($userId, $title, $subtitle, $redirectLink)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->redirectLink = $redirectLink;
    }

    public function broadcastOn()
    {
        return new Channel('notifications.' . $this->userId);
    }
}
