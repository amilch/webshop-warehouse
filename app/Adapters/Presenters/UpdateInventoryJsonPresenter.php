<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\InventoryUpdatedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\UpdateInventory\UpdateInventoryOutputPort;
use Domain\UseCases\UpdateInventory\UpdateInventoryResponseModel;

class UpdateInventoryJsonPresenter implements UpdateInventoryOutputPort
{
    public function inventoryUpdated(UpdateInventoryResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new InventoryUpdatedResource($model->getProduct())
        );
    }
}
