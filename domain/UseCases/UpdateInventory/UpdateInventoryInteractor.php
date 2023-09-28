<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Entities\Product\ProductFactory;
use Domain\Entities\Product\ProductRepository;
use Domain\Events\EventService;
use Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory;
use Domain\Interfaces\ViewModel;

class UpdateInventoryInteractor implements UpdateInventoryInputPort
{
    public function __construct(
        private UpdateInventoryOutputPort $output,
        private ProductRepository       $repository,
        private ProductFactory          $factory,
    ) {}

    public function updateInventory(UpdateInventoryRequestModel $request): ViewModel
    {
        $product = $this->repository->get($request->getSku());
        $product->setQuantityReserved($request->getQuantity(), $request->getReserved());

        return $this->output->inventoryUpdated(
            new UpdateInventoryResponseModel($product)
        );
    }
}
