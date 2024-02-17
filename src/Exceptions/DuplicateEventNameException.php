<?php

/**
 * Exception thrown when an attempt is made to register an event with a name that is already in use.
 *
 * Indicates that the unique constraint on event names has been violated, preventing the registration
 * of two or more events with the same name within the event management system.
 *
 * @package CommonPHP\Events\Exceptions
 */

namespace CommonPHP\Events\Exceptions;

use Throwable;

class DuplicateEventNameException extends EventException
{
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('The event `'.$name.'` has already been defined', $previous);
        $this->code = 1302;
    }
}