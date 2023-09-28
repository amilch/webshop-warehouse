<?php

namespace Domain\Entities\Product;

class AvailableQuantityGetter
{
    public function __construct(
        private ProductEntity $product
    ) {}

    public function get(): int
    {
        return $this->product->getQuantity() - $this->product->getReserved();
    }

}
