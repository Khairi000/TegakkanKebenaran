<?php

namespace App\Events;

use App\Models\Komentar;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class KomentarBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $komentar;

    public function __construct(Komentar $komentar)
    {
        $this->komentar = $komentar;
    }

    public function broadcastOn()
    {
        // Channel diskusi sesuai ID aspirasi
        return new Channel('diskusi.' . $this->komentar->aspirasi_id);
    }

    public function broadcastWith()
    {
        // Data yang dikirim ke front-end
        return [
            'id' => $this->komentar->id,
            'user' => $this->komentar->user->name,
            'pesan' => $this->komentar->pesan,
            'created_at' => $this->komentar->created_at->diffForHumans(),
        ];
    }

    public function broadcastAs()
    {
        return 'komentar.baru';
    }
}
