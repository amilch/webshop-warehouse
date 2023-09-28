<?php

namespace Domain\Events;

use Domain\Interfaces\Event;

class ProductCreatedEvent implements Event
{
    public function __construct(
        private string $sku
    ){}

    public static function fromArray(array $data): self
    {
        return new self($data['sku']);
    }

    public function toArray(): array {
        return [
            'sku' => $this->sku
        ];
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
