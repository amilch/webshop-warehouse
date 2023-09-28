<?php

namespace Domain\UseCases\CreateProduct;

use Domain\Events\ProductCreatedEvent;
use Domain\Interfaces\ViewModel;

interface CreateProductInputPort
{
    public function createProduct(ProductCreatedEvent $event): void;
}
