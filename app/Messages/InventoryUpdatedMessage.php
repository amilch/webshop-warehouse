<?php

namespace App\Messages;

use Domain\UseCases\UpdateInventory\InventoryUpdatedMessageModel;

class InventoryUpdatedMessage implements AMQPMessage
{
    public function __construct(
        private InventoryUpdatedMessageModel $message
    ) {}

    public function getRoutingKey(): string
    {
        return "inventory_updated";
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->message->getSku(),
            'quantity' => $this->message->getQuantity(),
        ];
    }
}
