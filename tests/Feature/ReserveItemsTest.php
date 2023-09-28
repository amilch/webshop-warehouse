<?php

namespace Tests\Feature;

use App\Models\Product;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReserveItemsTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    use WithoutMiddleware;

    public function test_reserving_items_fails_if_not_enough_available(): void
    {
        $product = Product::where('sku', 'kirsch_tomaten_samen')->first();
        $this->assertEquals(1, $product->getQuantity());
        $this->assertEquals(0, $product->getReserved());

        $response = $this->postJson('/reserve',[
            'items' => [
                [
                    'sku' => 'kirsch_tomaten_samen',
                    'quantity' => 2,
                ]
            ]
        ]);
        $response->assertStatus(409);

        $product = Product::where('sku', 'kirsch_tomaten_samen')->first();
        $this->assertEquals(1, $product->getQuantity());
        $this->assertEquals(0, $product->getReserved());
    }

    public function test_reserving_items_changes_reserved_count_if_availabe(): void
    {
        $product = Product::where('sku', 'kirsch_tomaten_samen')->first();
        $this->assertEquals(1, $product->getQuantity());
        $this->assertEquals(0, $product->getReserved());

        $response = $this->postJson('/reserve',[
            'items' => [
                [
                    'sku' => 'kirsch_tomaten_samen',
                    'quantity' => 1,
                ]
            ]
        ]);
        $response->assertStatus(200);

        $product = Product::where('sku', 'kirsch_tomaten_samen')->first();
        $this->assertEquals(1, $product->getQuantity());
        $this->assertEquals(1, $product->getReserved());
    }

    public function test_reserving_items_should_publish_message(): void
    {
        Amqp::shouldReceive('publish')
            ->once()
            ->withArgs([
                'inventory_updated',
                '{"sku":"kirsch_tomaten_samen","quantity":0}'
            ]);

        $response = $this->postJson('/reserve',[
            'items' => [
                [
                    'sku' => 'kirsch_tomaten_samen',
                    'quantity' => 1,
                ]
            ]
        ]);
        $response->assertStatus(200);
    }
}
