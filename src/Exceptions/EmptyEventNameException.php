<?php

/**
 * Exception thrown when an attempt is made to register or interact with an event without specifying a name.
 *
 * This exception is used to enforce the requirement that all events must have a non-empty, unique name
 * for registration and retrieval within the event management system.
 *
 * @package CommonPHP\Events\Exceptions
 */

namespace CommonPHP\Events\Exceptions;

use Throwable;

class EmptyEventNameException extends EventException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('An event name cannot be empty', $previous);
        $this->code = 1301;
    }
}