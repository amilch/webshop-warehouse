<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\ProductEntity;

class UpdateInventoryResponseModel
{
    public function __construct(private ProductEntity $product) {}

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }
}
