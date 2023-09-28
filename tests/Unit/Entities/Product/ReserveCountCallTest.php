<?php

namespace Tests\Unit\Entities\Product;

use Domain\Entities\Product\ProductEntity;
use Domain\Entities\Product\ReserveCountCall;
use Domain\Events\EventService;
use Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory;
use PHPUnit\Framework\TestCase;

class ReserveCountCallTest extends TestCase
{
    public function test_throws_error_when_trying_to_reserve_too_much()
    {
        $event_service = \Mockery::mock(EventService::class);
        $event_service->shouldReceive('publish')->never();

        $event_factory = \Mockery::mock(InventoryUpdatedEventFactory::class);
        $event_factory->shouldReceive('make')->never();

        $product = \Mockery::mock(ProductEntity::class);
        $product->shouldReceive('getAvailableQuantity')->andReturn(1);

        $under_test = new ReserveCountCall($product, $event_service, $event_factory);

        $this->expectException(\InvalidArgumentException::class);
        $under_test->set(2);
    }

}
