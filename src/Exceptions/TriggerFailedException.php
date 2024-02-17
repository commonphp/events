<?php

/**
 * Exception thrown when the event system encounters an error while attempting to trigger an event.
 *
 * This exception is used to signal failures in the event triggering process, potentially due to issues
 * executing one or more of the event's hooks. It wraps and provides context for underlying exceptions
 * that occur during event triggering.
 *
 * @package CommonPHP\Events\Exceptions
 */

namespace CommonPHP\Events\Exceptions;

use Throwable;

class TriggerFailedException extends EventException
{
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('The event `'.$name.'` was not successfully triggered', $previous);
        $this->code = 1304;
    }
}