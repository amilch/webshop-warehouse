<?php

namespace App\Repositories;

use App\Models\Product;
use Domain\Entities\Product\ProductEntity;
use Domain\Entities\Product\ProductRepository;

class ProductDatabaseRepository implements ProductRepository
{
    public function upsert(ProductEntity $product): ProductEntity
    {
        return Product::updateOrCreate([
            'sku' => $product->getSku(),
        ],
        [
            'sku' => $product->getSku(),
            'quantity' => $product->getQuantity(),
            'reserved' => $product->getReserved(),
        ]);
    }

    public function all(): array
    {
        return Product::all()->all();
    }

    public function get(string $sku): ProductEntity
    {
        return Product::where('sku', $sku)->limit(1)->get()->first();
    }
}
