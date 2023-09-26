<?php

namespace App\Adapters\Publishers;

use App\Messages\InventoryUpdatedMessage;
use App\Services\AMQPService;
use Domain\UseCases\UpdateInventory\UpdateInventoryMessageOutputPort;
use Domain\UseCases\UpdateInventory\InventoryUpdatedMessageModel;

class InventoryUpdatedMessagePublisher implements UpdateInventoryMessageOutputPort
{
    public function __construct(
        private readonly AMQPService $rabbitMQService
    ) {}
    public function inventoryUpdated(InventoryUpdatedMessageModel $model): void
    {
        $this->rabbitMQService->publish(
            new InventoryUpdatedMessage($model));
    }
}
