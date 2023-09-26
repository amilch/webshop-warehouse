<?php

namespace App\Console\Commands;

use Domain\UseCases\CreateProduct\CreateProductInputPort;
use Domain\UseCases\CreateProduct\CreateProductRequestModel;
use Illuminate\Console\Command;
use BSchmitt\Amqp\Facades\Amqp;
use BSchmitt\Amqp\Consumer;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;

class ConsumeAMQPCommand extends Command
{
    protected $signature = 'app:consume';

    protected $description = 'AMQP consumer';

    public function __construct(
        private CreateProductInputPort $interactor,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        var_dump('Listening for messages...');

        while(true) {
            Amqp::consume('inventory_product_created',
                function (AMQPMessage $message, Consumer $resolver) {
                    try{
                        $payload = json_decode($message->getBody(), true);
                        var_dump('Message received', $payload);

                        $this->interactor->createProduct(
                            new CreateProductRequestModel($payload)
                        );

                        $resolver->acknowledge($message);
                    } catch (Exception $e) {
                        var_dump('Error processing message');
                        var_dump($e->getMessage());
                        $resolver->reject($message);
                    }
                });
        }
    }
}
