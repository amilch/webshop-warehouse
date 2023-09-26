<?php

namespace Domain\UseCases\UpdateInventory;

class UpdateInventoryRequestModel
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

    public function getQuantity(): string
    {
        return $this->attributes['quantity'];
    }

    public function getReserved(): string
    {
        return $this->attributes['reserved'];
    }
}
