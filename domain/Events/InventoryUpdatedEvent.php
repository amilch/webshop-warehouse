<?php

namespace Domain\Events;

use Domain\Interfaces\Event;

class InventoryUpdatedEvent implements Event
{
    public function __construct(
        private string $sku,
        private int $quantity,
    ){}

    public static function fromArray(array $data): self
    {
        return new self($data['sku'], $data['quantity']);
    }

    public function toArray(): array {
        return [
            'sku' => $this->sku,
            'quantity' => $this->quantity,
        ];
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->sku;
    }
}
