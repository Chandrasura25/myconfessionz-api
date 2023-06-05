<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewMessageListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

     public function handle(MessageSent $event)
     {
         $message = new Message();
         $message->user_id = $event->message->sender_id;
         $message->counselor_id = $event->message->recipient_id;
         $message->content = $event->message->content;
         $message->save();
     }
}