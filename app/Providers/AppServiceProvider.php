<?php

namespace App\Providers;

use App\Factories\InventoryUpdatedAMQPEventFactory;
use Domain\Entities\Product\QuantityReservedSetter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Domain\Entities\Product\ProductRepository::class,
            \App\Repositories\ProductDatabaseRepository::class
        );

        $this->app->bind(
            \Domain\Entities\Product\ProductFactory::class,
            \App\Factories\ProductModelFactory::class
        );

        $this->app->bind(
            \Domain\Events\EventService::class,
            \App\Services\AMQPService::class,
        );

        $this->app->bind(
            \Domain\Events\InventoryUpdated\InventoryUpdatedEventFactory::class,
            \App\Factories\InventoryUpdatedAMQPEventFactory::class
        );

        $this->app
            ->when(\App\Http\Controllers\UpdateInventoryController::class)
            ->needs(\Domain\UseCases\UpdateInventory\UpdateInventoryInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\UpdateInventory\UpdateInventoryInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UpdateInventoryJsonPresenter::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\GetProductsController::class)
            ->needs(\Domain\UseCases\GetProducts\GetProductsInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\GetProducts\GetProductsInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\GetProductsJsonPresenter::class)
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\ReserveItemsController::class)
            ->needs(\Domain\UseCases\ReserveItems\ReserveItemsInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\ReserveItems\ReserveItemsInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\ReserveItemsJsonPresenter::class)
                ]);
            });

        $this->app
            ->when(\App\Console\Commands\ConsumeAMQPCommand::class)
            ->needs(\Domain\UseCases\CreateProduct\CreateProductInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\CreateProduct\CreateProductInteractor::class);
            });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
