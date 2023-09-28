<?php

namespace Domain\Entities;

class OrderItemEntity
{
    public function __construct(
        private string $sku,
        private int $quantity,
    ) {}

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
