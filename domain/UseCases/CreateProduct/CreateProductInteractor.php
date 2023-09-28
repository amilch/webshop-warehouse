<?php

namespace Domain\UseCases\CreateProduct;

use Domain\Entities\Product\ProductFactory;
use Domain\Entities\Product\ProductRepository;
use Domain\Events\ProductCreated\ProductCreatedEvent;

class CreateProductInteractor implements CreateProductInputPort
{
    public function __construct(
        private ProductRepository       $repository,
        private ProductFactory          $factory,
    ) {}

    public function createProduct(ProductCreatedEvent $event): void
    {
        var_dump($event->getSku());
        $product = $this->factory->make([
            'sku' => $event->getSku(),
            'quantity' => 0,
            'reserved' => 0,
        ]);

        $product = $this->repository->upsert($product);
    }
}
