<?php

namespace Domain\Events\InventoryUpdated;


use Domain\Events\Event;

interface InventoryUpdatedEventFactory
{
    public function make(string $sku, int $quantity): Event;
}
