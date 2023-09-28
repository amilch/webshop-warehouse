<?php

namespace Domain\UseCases\ReserveItems;

use Domain\Interfaces\ViewModel;

interface ReserveItemsOutputPort
{
    public function itemsReserved(ReserveItemsResponseModel $model): ViewModel;

    public function unableToReserveItems(): ViewModel;
}
