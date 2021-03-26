<?php

namespace App\Listeners;

use App\Events\ArtifactCreated;
use App\Models\User;
use App\Notifications\NewArtifactNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendArtifactCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ArtifactCreated $event
     * @return void
     */
    public function handle(ArtifactCreated $event)
    {
        User::all()->each(fn($user) => $user->notify(new NewArtifactNotification($event->artifact)));
    }
}
