<?php

namespace App\Http\Resources;

use Domain\Entities\Product\ProductEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryUpdatedResource extends JsonResource
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
