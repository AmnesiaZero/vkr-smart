<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class WorkUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $work;


    /**
     * Create a new event instance.
     */
    public function __construct(
         $work,
    )
    {
      $this->work = $work;
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('works.' . $this->work->id);
    }

    public function broadcastWith(): array
    {
        return ['work' => $this->work];
    }
}
