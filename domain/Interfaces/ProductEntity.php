<?php

namespace Domain\Interfaces;

use Domain\ValueObjects\MoneyValueObject;

interface ProductEntity
{
    public function getSku(): string;
    public function getQuantity(): int;

    public function getReserved(): int;

}
