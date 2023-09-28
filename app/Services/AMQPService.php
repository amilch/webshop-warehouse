<?php

namespace App\Services;

use App\Events\AMQPEvent;
use App\Messages\AMQPMessage;
use Bschmitt\Amqp\Facades\Amqp;
use Domain\Interfaces\Event;
use Domain\Interfaces\EventService;

class AMQPService implements EventService
{
    public function publish(Event $event): void
    {
        if ($event instanceof AMQPEvent) {
            $encodedMessage = json_encode($event->toArray());
            Amqp::publish($event->getRoutingKey(), $encodedMessage);
        }
    }
}
