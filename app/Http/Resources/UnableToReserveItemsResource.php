<?php

namespace App\Http\Resources;

use Domain\Interfaces\ProductEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class UnableToReserveItemsResource extends JsonResource
{
    public function __construct(
    ) {}

    public function toArray($request)
    {
        return [];
    }
}
