<?php

namespace Domain\UseCases\CreateProduct;

use Domain\Interfaces\MessageQueueService;
use Domain\Interfaces\ProductFactory;
use Domain\Interfaces\ProductRepository;
use Domain\Interfaces\ViewModel;

class CreateProductInteractor implements CreateProductInputPort
{
    public function __construct(
        private ProductRepository       $repository,
        private ProductFactory          $factory,
    ) {}

    public function createProduct(CreateProductRequestModel $request): void
    {
        var_dump($request->getSku());
        $product = $this->factory->make([
            'sku' => $request->getSku(),
            'quantity' => 0,
            'reserved' => 0,
        ]);

        $product = $this->repository->upsert($product);
    }
}
