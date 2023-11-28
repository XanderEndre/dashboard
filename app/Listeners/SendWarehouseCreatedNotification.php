<?php

namespace App\Listeners;

use App\Events\CreateWarehouseEvent;
use App\Events\WarehouseCreated;
use App\Models\User;
use App\Notifications\CreateWarehouseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWarehouseCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(CreateWarehouseEvent $event) : void
    {
        // // Assuming $admin is an instance of a User model, which you might retrieve like so:
        $admin = User::find(1);

        // // Then notify the admin user
        $admin->notify(new CreateWarehouseNotification($event->warehouse));
    }
}
