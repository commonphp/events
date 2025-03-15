<?php

namespace Neuron\Events;

/**
 * Defines the required contract for all event classes.
 */
interface EventInterface
{
    /**
     * Retrieves the event payload.
     *
     * @return array Event data.
     */
    public function getPayload(): array;
}