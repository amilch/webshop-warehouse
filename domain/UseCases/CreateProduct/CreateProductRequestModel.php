<?php

namespace Domain\UseCases\CreateProduct;

class CreateProductRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }
}
