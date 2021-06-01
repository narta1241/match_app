<?php
 
namespace App\Events;
 
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;
 
class ChatMessageRecieved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    protected $message;
    protected $request;
 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
 
    }
 
    /**
     * イベントをブロードキャストすべき、チャンネルの取得
     *
     * @return Channel|Channel[]
     */
    public function broadcastOn()
    {
 
        return new Channel('chat');
 
    }
 
    /**
     * ブロードキャストするデータを取得
     *
     * @return array
     */
    public function broadcastWith()
    {
        // dd($this);
        return [
            'room_id' => $this->request['room_id'],
            'text' => $this->request['text'],
            'user_id' => $this->request['user_id'],
            'receive_user_id' => $this->request['receive_user_id'],
        ];
    }
 
    /**
     * イベントブロードキャスト名
     *
     * @return string
     */
    public function broadcastAs()
    {
 
        return 'chat_event';
    }
}