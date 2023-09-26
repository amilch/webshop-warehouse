<?php

namespace App\Services;

use App\Messages\AMQPMessage;
use Bschmitt\Amqp\Facades\Amqp;
use Domain\Interfaces\Message;
use Domain\Interfaces\MessageQueueService;

class AMQPService implements MessageQueueService
{
    public function publish(Message $msg): void
    {
        if ($msg instanceof AMQPMessage) {
            $encodedMessage = json_encode($msg->toArray());
            Amqp::publish($msg->getRoutingKey(), $encodedMessage);
        }
    }
}
