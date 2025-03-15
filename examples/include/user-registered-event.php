<?php

use Neuron\Events\AbstractEvent;

class UserRegisteredEvent extends AbstractEvent
{
    public function __construct(string $username)
    {
        parent::__construct(['username' => $username]);
    }
}

