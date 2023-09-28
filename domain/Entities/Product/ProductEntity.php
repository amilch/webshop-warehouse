<?php

namespace Domain\Entities\Product;

interface ProductEntity
{
    public function getSku(): string;
    public function getQuantity(): int;

    public function getReserved(): int;

    public function setQuantityReserved(int $quantity, int $reserved): void;

    public function getAvailableQuantity(): int;

    public function reserve(int $count): void;
}
