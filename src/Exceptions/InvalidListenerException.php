<?php

namespace Neuron\Events\Exceptions;

use Neuron\Events\EventsException;
use Neuron\Events\ListenerInterface;
use Throwable;

/**
 * Exception thrown when an invalid listener is encountered.
 */
class InvalidListenerException extends EventsException
{
    /**
     * Constructs an InvalidListenerException.
     *
     * @param string $listener Invalid listener class name.
     * @param int $code Exception code.
     * @param Throwable|null $previous Previous exception.
     */
    public function __construct(string $listener, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The listener class `'.$listener.'` either does not exist or does not implement the '.ListenerInterface::class.' interface', $code, $previous);
    }
}