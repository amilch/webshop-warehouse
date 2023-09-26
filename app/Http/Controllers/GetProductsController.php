<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use Domain\UseCases\GetProducts\GetProductsInputPort;

class GetProductsController extends Controller
{
    public function __construct(
        private GetProductsInputPort $interactor,
    ) {}

    public function __invoke()
    {
        $viewModel = $this->interactor->getProducts();

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }

}
