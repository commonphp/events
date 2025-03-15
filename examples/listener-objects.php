<?php

use Neuron\Events\EventDispatcher;

require '../vendor/autoload.php';
require 'include/user-registered-event.php';
require 'include/welcome-email-listener.php';

$dispatcher = new EventDispatcher();
$dispatcher->listen(UserRegisteredEvent::class, [new WelcomeEmailListener(), 'handle']);
$dispatcher->dispatch(new UserRegisteredEvent('Alice')); // Expected output: Sending welcome email to: Alice