<?php

namespace Tests\Feature;

use App\Models\Product;
use Domain\Events\ProductCreated\ProductCreatedEvent;
use Domain\UseCases\CreateProduct\CreateProductInteractor;
use Domain\UseCases\CreateProduct\CreateProductRequestModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    use WithoutMiddleware;

    public function test_when_receiving_product_created_message_create_product(): void
    {
        $interactor = app()->make(CreateProductInteractor::class);

        $this->assertTrue(Product::where('sku', 'new_product')->get()->isEmpty());

        $interactor->createProduct(
            new ProductCreatedEvent("new_product"));

        $this->assertFalse(Product::where('sku', 'new_product')->get()->isEmpty());
        $product = Product::where('sku', 'new_product')->first();
        $this->assertEquals(0, $product->getQuantity());
        $this->assertEquals(0, $product->getReserved());
    }
}
