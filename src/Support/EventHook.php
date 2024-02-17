<?php

/**
 * Represents a hook (callback) attached to an event, including the callback function and its priority.
 *
 * Used internally by the Event class to manage and execute callbacks in response to event triggers.
 * Supports prioritization to control the order of execution among multiple hooks attached to the same
 * event. This class encapsulates the callback alongside its execution priority.
 *
 * @package CommonPHP\Events\Support
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Events\Support;

use Closure;

final readonly class EventHook
{
    /** @var Closure The closure to execute when the event is triggered. */
    public Closure $closure;

    /** @var int The priority of the hook, determining its execution order. */
    public int $priority;

    /**
     * Constructs a new EventHook with the given callback and priority.
     *
     * @param callable|Closure $callback The callback function for the hook.
     * @param int $priority The priority of the hook.
     */
    public function __construct(callable|Closure $callback, int $priority = 0)
    {
        if (!($callback instanceof Closure))
        {
            $callback = $callback(...);
        }
        $this->closure = $callback;
        $this->priority = $priority;
    }
}