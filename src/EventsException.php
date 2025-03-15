<?php

namespace Neuron\Events;

use Exception;
use Throwable;

/**
 * Base exception class for event-related errors.
 */
class EventsException extends Exception
{
    /**
     * Constructs an EventsException.
     *
     * @param string $message Exception message.
     * @param int $code Exception code.
     * @param Throwable|null $previous Previous exception.
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}