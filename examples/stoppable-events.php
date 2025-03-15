<?php

use Neuron\Events\EventDispatcher;

require '../vendor/autoload.php';
require 'include/order-placed-event.php';

$dispatcher = new EventDispatcher();
$dispatcher->listen(OrderPlacedEvent::class, function (OrderPlacedEvent $event) {
    echo "Order placed: Processing payment...\n";
    $event->stopPropagation(); // Stops further listeners from being executed
});
$dispatcher->listen(OrderPlacedEvent::class, function () {
    echo "This should not execute due to event propagation stopping.\n";
});
$dispatcher->dispatch(new OrderPlacedEvent(['order_id' => 123])); // Expected output: Order placed: Processing payment...