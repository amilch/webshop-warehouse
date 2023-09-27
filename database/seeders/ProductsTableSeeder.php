<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        $json = File::get('database/seeders/products.json');
        $products = json_decode($json, true);

        foreach ($products as $product)
        {
            Product::create([
                'sku' => $product['sku'],
                'quantity' => $product['quantity'],
                'reserved' => $product['reserved'],
            ]);
        }
    }
}
