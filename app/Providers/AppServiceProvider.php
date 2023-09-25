<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Domain\Interfaces\CategoryRepository::class,
            \App\Repositories\CategoryDatabaseRepository::class
        );

        $this->app
            ->when(\App\Http\Controllers\GetAllCategoriesController::class)
            ->needs(\Domain\UseCases\GetAllCategories\GetAllCategoriesInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\GetAllCategories\GetAllCategoriesInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\GetAllCategoriesJsonPresenter::class)
                ]);
            });

        $this->app->bind(
            \Domain\Interfaces\ProductRepository::class,
            \App\Repositories\ProductDatabaseRepository::class
        );

        $this->app->bind(
            \Domain\Interfaces\ProductFactory::class,
            \App\Factories\ProductModelFactory::class
        );

        $this->app
            ->when(\App\Http\Controllers\CreateProductController::class)
            ->needs(\Domain\UseCases\CreateProduct\CreateProductInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\CreateProduct\CreateProductInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\CreateProductJsonPresenter::class),
                    'messageOutput' => $app->make(\App\Adapters\Publishers\ProductCreatedMessagePublisher::class),
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

        $this->app->bind(
            \Domain\Interfaces\MessageQueueService::class,
            \App\Services\RabbitMQService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
