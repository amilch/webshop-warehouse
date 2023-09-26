<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\Message;

class InventoryUpdatedMessageModel implements Message
{
    public function __construct(
        private array $attributes
    ) {}

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getQuantity(): string
    {
        return $this->attributes['quantity'];
    }
}
