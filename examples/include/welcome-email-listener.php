<?php

use Neuron\Events\EventInterface;
use Neuron\Events\ListenerInterface;

class WelcomeEmailListener implements ListenerInterface
{
    public function handle(EventInterface $event): void
    {
        echo "Sending welcome email to: " . $event->getPayload()['username'] . "\n";
    }
}

