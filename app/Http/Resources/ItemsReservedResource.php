<?php

namespace App\Http\Resources;

use Domain\Interfaces\ProductEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsReservedResource extends JsonResource
{
    public function __construct(
        protected ProductEntity $product
    ) {}

    public function toArray($request)
    {
        return [
            'sku' => $this->product->getSku(),
            'quantity' => $this->product->getQuantity(),
            'reserved' => $this->product->getReserved(),
        ];
    }
}
