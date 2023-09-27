<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_returns_all_products(): void
    {
        $response = $this->getJson('/products');
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', 20, fn(AssertableJson $json) => $json
                    ->where('sku', 'kirsch_tomaten_samen')
                    ->where('quantity', 1)
                    ->where('reserved', 0)
                )
            );
    }

    public function test_returns_empty_when_no_products(): void
    {
        Product::truncate();
        $response = $this->getJson('/products');
        $response
            ->assertStatus(200)
            ->assertJsonIsArray('data')
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', 0)
            );
    }
}
