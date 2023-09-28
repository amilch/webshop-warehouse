<?php

namespace Domain\UseCases\CreateProduct;

use Domain\Events\ProductCreated\ProductCreatedEvent;

interface CreateProductInputPort
{
    public function createProduct(ProductCreatedEvent $event): void;
}
