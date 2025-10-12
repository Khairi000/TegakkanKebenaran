<?php

namespace App\Events;

use App\Models\Diskusi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiskusiBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $diskusi;

    /**
     * Create a new event instance.
     *
     * @param Diskusi $diskusi
     */
    public function __construct(Diskusi $diskusi)
    {
        // Load relasi user agar langsung bisa diakses di frontend
        $this->diskusi = $diskusi->load('user');
    }

    /**
     * The channel the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // Channel publik khusus aspirasi
        return new Channel('diskusi.' . $this->diskusi->aspirasi_id);
    }

    /**
     * Nama event yang dikirim ke frontend
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'DiskusiBaru';
    }

    /**
     * Data yang dikirim ke frontend
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'diskusi' => [
                'id' => $this->diskusi->id,
                'isi' => $this->diskusi->isi,
                'user' => [
                    'id' => $this->diskusi->user->id,
                    'name' => $this->diskusi->user->name,
                ],
                'created_at' => $this->diskusi->created_at->toDateTimeString(),
            ],
        ];
    }
}
