<?php

namespace Domain\UseCases\ReserveItems;

use Domain\Entities\Product\ProductFactory;
use Domain\Entities\Product\ProductRepository;
use Domain\Interfaces\ViewModel;

class ReserveItemsInteractor implements ReserveItemsInputPort
{
    public function __construct(
        private ReserveItemsOutputPort  $output,
        private ProductRepository       $repository,
    ) {}

    public function reserveItems(ReserveItemsRequestModel $request): ViewModel
    {
        $order_items = $request->getItems();

        foreach ($order_items as $item)
        {
            $product = $this->repository->get($item['sku']);
            if ($product->getAvailableQuantity() < $item['quantity'])
            {
                return $this->output->unableToReserveItems();
            }
        }

        foreach ($order_items as $item)
        {
            $product = $this->repository->get($item['sku']);
            $product->reserve($item['quantity']);
        }

        return $this->output->itemsReserved(
            new ReserveItemsResponseModel($product)
        );
    }
}
