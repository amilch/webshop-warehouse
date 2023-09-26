<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\ViewModel;

interface UpdateInventoryInputPort
{
    public function updateInventory(UpdateInventoryRequestModel $request): ViewModel;
}
