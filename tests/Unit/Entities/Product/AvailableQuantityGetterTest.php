<?php

namespace Tests\Entities\Product;

use Domain\Entities\Product\AvailableQuantityGetter;
use Domain\Entities\Product\ProductEntity;
use PHPUnit\Framework\TestCase;

class AvailableQuantityGetterTest extends TestCase
{
    public function test_available_quantity_is_correct()
    {
        $product = \Mockery::mock(ProductEntity::class);
        $product->shouldReceive('getQuantity')->andReturn(4);
        $product->shouldReceive('getReserved')->andReturn(3);

        $under_test = new AvailableQuantityGetter($product);

        $this->assertEquals(1, $under_test->get());
    }
}
