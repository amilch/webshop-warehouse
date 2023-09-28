<?php

namespace Domain\UseCases\ReserveItems;

use Domain\Entities\Product\ProductEntity;

class ReserveItemsResponseModel
{
    public function __construct(private ProductEntity $product) {}

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }
}
