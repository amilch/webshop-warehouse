<?php

namespace Domain\UseCases\ReserveItems;

use Domain\Interfaces\ViewModel;

interface ReserveItemsInputPort
{
    public function reserveItems(ReserveItemsRequestModel $request): ViewModel;
}
