<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Events\InventoryUpdatedEvent;
use Domain\Interfaces\EventService;
use Domain\Interfaces\InventoryUpdatedEventFactory;
use Domain\Interfaces\ProductFactory;
use Domain\Interfaces\ProductRepository;
use Domain\Interfaces\ViewModel;

class UpdateInventoryInteractor implements UpdateInventoryInputPort
{
    public function __construct(
        private UpdateInventoryOutputPort $output,
        private ProductRepository       $repository,
        private ProductFactory          $factory,
        private EventService            $eventService,
        private InventoryUpdatedEventFactory $inventoryUpdatedEventFactory,
    ) {}

    public function updateInventory(UpdateInventoryRequestModel $request): ViewModel
    {
        $product = $this->factory->make([
            'sku' => $request->getSku(),
            'quantity' => $request->getQuantity(),
            'reserved' => $request->getReserved(),
        ]);

        $product = $this->repository->upsert($product);

        $real_quantity = $product->getQuantity() - $product->getReserved();
        $event = $this->inventoryUpdatedEventFactory->make($product->getSku(), $real_quantity);
        $this->eventService->publish($event);

        return $this->output->inventoryUpdated(
            new UpdateInventoryResponseModel($product)
        );
    }
}
