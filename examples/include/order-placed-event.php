<?php

use Neuron\Events\AbstractEvent;
use Psr\EventDispatcher\StoppableEventInterface;

class OrderPlacedEvent extends AbstractEvent implements StoppableEventInterface
{
    private bool $stopped = false;
    public function isPropagationStopped(): bool { return $this->stopped; }
    public function stopPropagation(): void { $this->stopped = true; }
}