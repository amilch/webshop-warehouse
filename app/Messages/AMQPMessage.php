<?php

namespace App\Messages;

use Domain\Interfaces\Message;

interface AMQPMessage extends Message
{
    public function getRoutingKey(): string;

    public function toArray(): array;

}
