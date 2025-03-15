<?php

use Neuron\Events\EventDispatcher;

require '../vendor/autoload.php';
require 'include/user-registered-event.php';

$dispatcher = new EventDispatcher();
$dispatcher->listen(UserRegisteredEvent::class, function (UserRegisteredEvent $event) {
    echo "User registered: " . $event->getPayload()['username'] . "\n";
});
$dispatcher->dispatch(new UserRegisteredEvent('Tim')); // Expected output: User registered: Tim