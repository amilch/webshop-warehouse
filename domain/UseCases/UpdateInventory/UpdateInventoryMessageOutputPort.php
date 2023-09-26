<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\Message;

interface UpdateInventoryMessageOutputPort
{
    public function inventoryUpdated(InventoryUpdatedMessageModel $model): void;
}
