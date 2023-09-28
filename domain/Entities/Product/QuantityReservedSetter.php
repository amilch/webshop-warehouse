<?php

namespace Domain\Entities\Product;

use Domain\Events\EventService;
use Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory;
use http\Exception\InvalidArgumentException;

class QuantityReservedSetter
{
    public function __construct(
        private ProductEntity $product,
        private EventService            $eventService,
        private InventoryUpdatedEventFactory $inventoryUpdatedEventFactory,
    ) {}

    public function set(int $quantity, int $reserved): array
    {
        if ($quantity < $reserved)
        {
            throw new InvalidArgumentException();
        }

        $event = $this->inventoryUpdatedEventFactory->make($this->product->getSku(), $quantity - $reserved);
        $this->eventService->publish($event);

        return [$quantity, $reserved];
    }

}
