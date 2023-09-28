<?php

namespace App\Factories;

use App\Events\InventoryUpdatedAMQPEvent;
use Domain\Events\Event;
use Domain\Events\InventoryUpdated\InventoryUpdatedEvent;
use Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory;

class InventoryUpdatedAMQPEventFactory implements InventoryUpdatedEventFactory
{
    public function make(string $sku, int $quantity): Event
    {
        return new InventoryUpdatedAMQPEvent(
            new InventoryUpdatedEvent($sku, $quantity));
    }
}
