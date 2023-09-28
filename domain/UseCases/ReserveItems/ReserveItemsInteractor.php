<?php

namespace Domain\UseCases\ReserveItems;

use Domain\Interfaces\MessageQueueService;
use Domain\Interfaces\ProductFactory;
use Domain\Interfaces\ProductRepository;
use Domain\Interfaces\ViewModel;

class ReserveItemsInteractor implements ReserveItemsInputPort
{
    public function __construct(
        private ReserveItemsOutputPort $output,
        private ProductRepository       $repository,
        private ProductFactory          $factory,
    ) {}

    public function reserveItems(ReserveItemsRequestModel $request): ViewModel
    {
        $order_items = $request->getItems();

        foreach ($order_items as $item)
        {
            $product = $this->repository->get($item['sku']);
            if (($product->getQuantity() - $product->getReserved()) < $item['quantity'])
            {
                return $this->output->unableToReserveItems();
            }
        }

        foreach ($order_items as $item)
        {
            $product = $this->repository->get($item['sku']);
            $product->setReserved($product->getReserved() + $item['quantity']);
        }

        return $this->output->itemsReserved(
            new ReserveItemsResponseModel($product)
        );
    }
}
