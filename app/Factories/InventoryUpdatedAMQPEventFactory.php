<?php

namespace App\Factories;

use App\Events\InventoryUpdatedAMQPEvent;
use Domain\Events\InventoryUpdatedEvent;
use Domain\Interfaces\Event;
use Domain\Interfaces\InventoryUpdatedEventFactory;

class InventoryUpdatedAMQPEventFactory implements InventoryUpdatedEventFactory
{
    public function make(string $sku, int $quantity): Event
    {
        return new InventoryUpdatedAMQPEvent(
            new InventoryUpdatedEvent($sku, $quantity));
    }
}
