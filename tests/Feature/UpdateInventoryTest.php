<?php

namespace Tests\Feature;

use App\Models\Product;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateInventoryTest extends TestCase
{
    public function test_updating_inventory_changes_the_quantity(): void
    {
        Amqp::shouldReceive('publish')->once();

        $response = $this->postJson('/products',[
            'sku' => 'kirsch_tomaten_samen',
            'quantity' => 200,
            'reserved' => 100,
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('sku', 'kirsch_tomaten_samen')
                    ->where('quantity', 200)
                    ->where('reserved', 100)
                )
            );

        $product = Product::where('sku', 'kirsch_tomaten_samen')->first();
        $this->assertEquals(200, $product->getQuantity());
        $this->assertEquals(100, $product->getReserved());
    }

    public function test_updating_inventory_publishes_message(): void
    {
        Amqp::shouldReceive('publish')
            ->once()
            ->withArgs([
                'inventory_updated',
                '{"sku":"kirsch_tomaten_samen","quantity":200}'
            ]);

        $response = $this->postJson('/products',[
            'sku' => 'kirsch_tomaten_samen',
            'quantity' => 200,
            'reserved' => 100,
        ]);
        $response->assertStatus(200);
    }
}
