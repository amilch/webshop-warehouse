<?php

namespace Domain\UseCases\ReserveItems;

class ReserveItemsRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}

    public function getItems(): array
    {
        return $this->attributes['items'];
    }
}
