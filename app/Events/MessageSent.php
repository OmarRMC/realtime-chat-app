<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): Channel|PrivateChannel
    {
        //\Log::info(['Mensaje enviado: ' => $this->message]);
        //return new PrivateChannel('chat.' . $this->message->receiver_id);
        if ($this->message->receiver_id) {
            return new PrivateChannel('chat.' . $this->message->receiver_id); // Canal privado para mensajes directos
        }

        return new Channel('chat.global');// Canal publico para mensajes globales (Para el seg. se configura en channels)
    }
}
