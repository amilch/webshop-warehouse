<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\ViewModel;

interface UpdateInventoryOutputPort
{
    public function inventoryUpdated(UpdateInventoryResponseModel $model): ViewModel;
}
