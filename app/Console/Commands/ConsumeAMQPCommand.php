<?php

namespace App\Console\Commands;

use BSchmitt\Amqp\Consumer;
use BSchmitt\Amqp\Facades\Amqp;
use Domain\Events\ProductCreated\ProductCreatedEvent;
use Domain\UseCases\CreateProduct\CreateProductInputPort;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeAMQPCommand extends Command
{
    protected $signature = 'app:consume';

    protected $description = 'AMQP consumer';

    private $should_keep_running = true;

    public function __construct(
        private CreateProductInputPort $interactor,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->trap(15, fn () => $this->should_keep_running = false);
        var_dump('Listening for messages...');

        Amqp::consume('warehouse_product_created',
            function (AMQPMessage $message, Consumer $resolver) {
                try{
                    $payload = json_decode($message->getBody(), true);
                    var_dump('Message received', $payload);

                    $this->interactor->createProduct(
                        ProductCreatedEvent::fromArray($payload)
                    );

                    $resolver->acknowledge($message);
                } catch (Exception $e) {
                    var_dump('Error processing message');
                    var_dump($e->getMessage());
                    $resolver->reject($message);
                }
            }, [
                'routing' => 'product_created',
                'persistent' => true,
            ]);

        while($this->should_keep_running) {}
    }
}
