<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\ItemsReservedResource;
use App\Http\Resources\ReservedItemsResource;
use App\Http\Resources\UnableToReserveItemsResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\ReserveItems\ReserveItemsOutputPort;
use Domain\UseCases\ReserveItems\ReserveItemsResponseModel;

class ReserveItemsJsonPresenter implements ReserveItemsOutputPort
{
    public function itemsReserved(ReserveItemsResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ItemsReservedResource($model->getProduct())
        );
    }

    public function unableToReserveItems(): ViewModel
    {
        return new JsonResourceViewModel(
            new UnableToReserveItemsResource(),
            409,
        );
    }
}
