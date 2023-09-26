<?php

namespace Domain\UseCases\UpdateInventory;

use Domain\Interfaces\MessageQueueService;
use Domain\Interfaces\ProductFactory;
use Domain\Interfaces\ProductRepository;
use Domain\Interfaces\ViewModel;

class UpdateInventoryInteractor implements UpdateInventoryInputPort
{
    public function __construct(
        private UpdateInventoryOutputPort $output,
        private UpdateInventoryMessageOutputPort $messageOutput,
        private ProductRepository       $repository,
        private ProductFactory          $factory,
    ) {}

    public function updateInventory(UpdateInventoryRequestModel $request): ViewModel
    {
        $product = $this->factory->make([
            'sku' => $request->getSku(),
            'quantity' => $request->getQuantity(),
            'reserved' => $request->getReserved(),
        ]);

        $product = $this->repository->upsert($product);

        $message = new InventoryUpdatedMessageModel([
            'sku' => $product->getSku(),
            'quantity' => $product->getQuantity(),
        ]);
        $this->messageOutput->inventoryUpdated($message);

        return $this->output->inventoryUpdated(
            new UpdateInventoryResponseModel($product)
        );
    }
}
