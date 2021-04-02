<?php

namespace Tests\Feature\Listeners;

use App\Events\ArtifactCreated;
use App\Listeners\SendArtifactCreatedNotification;
use App\Models\Artifact;
use App\Models\User;
use App\Notifications\NewArtifactNotification;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

/**
 * Class LenderTest
 * @covers \App\Listeners\SendArtifactCreatedNotification;
 *
 * @package Tests\Feature\Listeners
 */
class SendArtifactCreatedNotificationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $listener = new SendArtifactCreatedNotification;

        //Dummy
        $eventDummy = Mockery::mock(ArtifactCreated::class);
        $listener->handle($eventDummy);


        //Stub
        $user = User::factory()->create();
        $eventStub = Mockery::mock(ArtifactCreated::class)
            ->shouldReceive('getArtifact')
            ->andReturn(new Artifact)
            ->getMock();
        Notification::fake();
        /** @var ArtifactCreated $eventStub */
        $listener->handle($eventStub);
        Notification::assertSentTo($user, NewArtifactNotification::class);

        //Mock
        $user = User::factory()->create();
        $notificationMock = Mockery::mock(ArtifactCreated::class)
            ->shouldReceive('getArtifact')
            ->times(1)
            ->andReturn(new Artifact)
            ->getMock();
        Notification::fake();
        /** @var ArtifactCreated $notificationMock */
        $listener->handle($notificationMock);
        Notification::assertSentTo($user, NewArtifactNotification::class);



    }
}
