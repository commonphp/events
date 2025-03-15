<?php

namespace Neuron\Events;

/**
 * Defines the required contract for all listener classes.
 */
interface ListenerInterface
{
    /**
     * Handles the provided event.
     *
     * @param EventInterface $event Event instance.
     */
    public function handle(EventInterface $event): void;
}