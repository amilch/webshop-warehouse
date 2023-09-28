<?php

namespace Domain\Interfaces;


interface ProductRepository
{
    public function upsert(ProductEntity $product): ProductEntity;

    public function all(): array;

    public function get(string $sku):  ProductEntity;
}
