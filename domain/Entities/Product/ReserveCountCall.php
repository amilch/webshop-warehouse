<?php

namespace Domain\Entities\Product;

use Domain\Events\EventService;
use Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory;
use InvalidArgumentException;

class ReserveCountCall
{
    public function __construct(
        private ProductEntity $product,
        private EventService            $eventService,
        private InventoryUpdatedEventFactory $inventoryUpdatedEventFactory,
    ) {}

    public function set(int $count): int
    {
        if ($this->product->getAvailableQuantity() - $count < 0)
        {
            throw new InvalidArgumentException();
        }

        $event = $this->inventoryUpdatedEventFactory->make($this->product->getSku(), $this->product->getAvailableQuantity() - $count);
        $this->eventService->publish($event);

        return $this->product->getReserved() + $count;
    }
}
