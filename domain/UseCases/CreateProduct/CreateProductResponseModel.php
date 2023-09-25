<?php

namespace Domain\UseCases\CreateProduct;

use Domain\Interfaces\ProductEntity;

class CreateProductResponseModel
{
    public function __construct(private ProductEntity $product) {}

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }
}
