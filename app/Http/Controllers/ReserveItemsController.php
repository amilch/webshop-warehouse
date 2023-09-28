<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\ReserveItemsRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Domain\UseCases\ReserveItems\ReserveItemsInputPort;
use Domain\UseCases\ReserveItems\ReserveItemsRequestModel;
use Domain\UseCases\UpdateInventory\UpdateInventoryInputPort;
use Domain\UseCases\UpdateInventory\UpdateInventoryRequestModel;

class ReserveItemsController extends Controller
{
    public function __construct(
        private ReserveItemsInputPort $interactor,
    ) {}

    public function __invoke(ReserveItemsRequest $request)
    {
        $viewModel = $this->interactor->reserveItems(
            new ReserveItemsRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
