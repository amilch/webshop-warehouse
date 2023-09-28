<?php

namespace App\Events;

use Domain\Events\InventoryUpdated\InventoryUpdatedEvent;

class InventoryUpdatedAMQPEvent implements AMQPEvent
{
    public function __construct(
        private InventoryUpdatedEvent $event
    ) {}

    public function getRoutingKey(): string
    {
        return "inventory_updated";
    }

    public function toArray(): array
    {
        return $this->event->toArray();
    }

    public static function fromArray(array $data): self
    {
        return new self(InventoryUpdatedEvent::fromArray($data));
    }
}
