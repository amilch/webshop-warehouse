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

        $real_quantity = $product->getQuantity() - $product->getReserved();
        $message = new InventoryUpdatedMessageModel([
            'sku' => $product->getSku(),
            'quantity' => $real_quantity
        ]);
        $this->messageOutput->inventoryUpdated($message);

        return $this->output->inventoryUpdated(
            new UpdateInventoryResponseModel($product)
        );
    }
}
