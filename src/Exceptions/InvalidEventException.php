<?php

namespace Neuron\Events\Exceptions;

use Neuron\Events\EventInterface;
use Neuron\Events\EventsException;
use Throwable;

/**
 * Exception thrown when an invalid event class is encountered.
 */
class InvalidEventException extends EventsException
{
    /**
     * Constructs an InvalidEventException.
     *
     * @param string $event Invalid event class name.
     * @param int $code Exception code.
     * @param Throwable|null $previous Previous exception.
     */
    public function __construct(string $event, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The event class `'.$event.'` either does not exist or does not implement the '.EventInterface::class.' interface', $code, $previous);
    }
}