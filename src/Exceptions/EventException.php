<?php

/**
 * Base exception class for all event-related exceptions within the CommonPHP Events library.
 *
 * This class extends the standard PHP Exception class, providing a common base for more specific
 * event-related exceptions. It sets a default error code for all event exceptions and allows for
 * easy identification and handling of exceptions thrown by the event management system.
 *
 * @package CommonPHP\Events\Exceptions
 */

namespace CommonPHP\Events\Exceptions;

use Exception;
use Throwable;

class EventException extends Exception
{
    public function __construct(string $message = "", ?Throwable $previous = null)
    {
        parent::__construct($message, 1300, $previous);
    }
}