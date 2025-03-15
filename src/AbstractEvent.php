<?php

namespace Neuron\Events;

/**
 * Abstract class representing a basic event structure.
 * Implements the EventInterface and provides a default payload implementation.
 */
abstract class AbstractEvent implements EventInterface
{
    /**
     * @var array The event payload data.
     */
    protected array $payload;

    /**
     * Constructor for AbstractEvent.
     *
     * @param array $payload Event-related data.
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @inheritDoc
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
 }