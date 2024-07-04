<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class WorkUpdated implements ShouldBroadcast
{
    use SerializesModels;


    /**
     * Create a new event instance.
     */
    public function __construct(
        public $work,
    ) {

    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('works.'.$this->work->id);
    }

    public function broadcastWith(): array
    {
        return ['work' => $this->work];
    }
}
