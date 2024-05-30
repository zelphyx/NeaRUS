<?php

namespace App\Events;

use App\Models\Owner;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOwnerRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ownerRequest;

    public function __construct(Owner $ownerRequest)
    {
        $this->ownerRequest = $ownerRequest;
    }

    public function broadcastOn()
    {
        return new Channel('owner-requests');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->ownerRequest->id,
            'name' => $this->ownerRequest->name,
            'email' => $this->ownerRequest->email,
            'phonenumber' => $this->ownerRequest->phonenumber,
        ];
    }
}
