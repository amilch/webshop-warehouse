<?php

namespace Domain\Interfaces;

interface ProductEntity
{
    public function getSku(): string;
    public function getQuantity(): int;

    public function getReserved(): int;

    public function setReserved(int $new): void;
}
