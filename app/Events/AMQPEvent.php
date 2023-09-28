<?php

namespace App\Events;

use Domain\Interfaces\Event;

interface AMQPEvent extends Event
{
    public function getRoutingKey(): string;
}
