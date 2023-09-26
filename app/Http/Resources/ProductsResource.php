<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    public function __construct(
        protected array $products
    ) {}

    public function toArray($request)
    {
        return [
            'data' => array_map(fn ($product) => [
                'sku' => $product->getSku(),
                'quantity' => $product->getQuantity(),
                'reserved' => $product->getReserved(),
            ], $this->products),
        ];
    }
}
