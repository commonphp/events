<?php

/**
 * Exception thrown when an operation references an event name that does not exist within the system's registry.
 *
 * Used to indicate that the specified event name has not been registered and thus cannot be retrieved or manipulated,
 * ensuring the integrity of event operations within the event management system.
 *
 * @package CommonPHP\Events\Exceptions
 */

namespace CommonPHP\Events\Exceptions;

use Throwable;

class EventNotDefinedException extends EventException
{
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('The event `'.$name.'` does not exist', $previous);
        $this->code = 1303;
    }
}