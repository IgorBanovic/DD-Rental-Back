<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MoveCar implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $car;
    /**
     * Create a new event instance.
     */
    public function __construct(Car $car)
    {
        $this->car = [
            'id' => $car->id,
            'latitude' => $car->latitude,
            'longitude' => $car->longitude,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('car-tracking'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'car-moved';
    }

    public function broadcastWith(): array
    {
        return [
            'car' => $this->car
        ];
    }
}
