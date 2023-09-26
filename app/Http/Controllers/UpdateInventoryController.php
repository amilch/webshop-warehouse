<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\UpdateInventoryRequest;
use Domain\UseCases\UpdateInventory\UpdateInventoryInputPort;
use Domain\UseCases\UpdateInventory\UpdateInventoryRequestModel;

class UpdateInventoryController extends Controller
{
    public function __construct(
        private UpdateInventoryInputPort $interactor,
    ) {}

    public function __invoke(UpdateInventoryRequest $request)
    {
        $viewModel = $this->interactor->updateInventory(
            new UpdateInventoryRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
