<?php

namespace App\Providers;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Listeners\NewMessageListener;
use Illuminate\Support\Facades\Event;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Event::listen(
            MessageSent::class,
            [NewMessageListener::class, 'handle']
        );

        Broadcast::channel('chat', function ($user) {
            // Check if the user is a user or a counselor
            if ($user->role === 'user' || $user->role === 'counselor') {
                return ['id' => $user->id, 'role' => $user->role];
            }

            return null; // User is not authorized to listen to the channel
        });

        Broadcast::routes();

        require base_path('routes/channels.php');
    }

}
