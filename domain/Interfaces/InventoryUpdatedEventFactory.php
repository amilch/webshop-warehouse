<?php

namespace Domain\Interfaces;


interface InventoryUpdatedEventFactory
{
    public function make(string $sku, int $quantity): Event;
}
