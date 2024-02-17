<?php

/**
 * Represents an individual event, encapsulating the logic for hook registration, priority management,
 * and event triggering.
 *
 * This class is designed to work within the EventManager ecosystem, providing the functionality to
 * attach callbacks (hooks) to events and trigger those callbacks when the event is fired. Supports
 * priority-based execution order for hooks and integrates with the ServiceManager for dependency
 * injection when invoking callbacks.
 *
 * @package CommonPHP\Events\Support
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Events\Support;

use Closure;
use CommonPHP\DependencyInjection\Exceptions\CallFailedException;
use CommonPHP\Events\Exceptions\TriggerFailedException;
use CommonPHP\ServiceManagement\ServiceManager;

final class Event
{
    /** @var string The name of the event. */
    public readonly string $name;

    /** @var EventHook[] Array of hooks registered to this event. */
    private array $hooks = [];

    /** @var bool Whether the hooks are sorted by priority. */
    private bool $is_sorted = true;

    /** @var ServiceManager The service manager instance used for dependency injection. */
    private ServiceManager $serviceManager;

    /**
     * Constructs an event with the given name.
     *
     * @param ServiceManager $serviceManager The service manager instance.
     * @param string $name The name of the event.
     */
    public function __construct(ServiceManager $serviceManager, string $name)
    {
        $this->name = $name;
        $this->serviceManager = $serviceManager;
    }

    /**
     * Clears all hooks from the event.
     */
    public function clear(): void
    {
        for ($i = 0; $i < count($this->hooks); $i++)
        {
            unset($this->hooks[$i]);
        }
        $this->is_sorted = true;
    }

    /**
     * Registers a hook to the event.
     *
     * @param callable|Closure $callback The callback function for the hook.
     * @param int $priority The priority of the hook.
     */
    public function hook(callable|Closure $callback, int $priority = 0): void
    {
        $this->is_sorted = false;
        if (!($callback instanceof Closure))
        {
            $callback = $callback(...);
        }
        $this->hooks[] = new EventHook($callback, $priority);
    }

    /**
     * Triggers the event, executing all hooks in priority order.
     *
     * @param array $parameters Parameters to pass to the hook callbacks.
     * @throws TriggerFailedException
     */
    public function trigger(array $parameters = []): void
    {
        if (!$this->is_sorted)
        {
            usort($this->hooks, function (EventHook $a, EventHook $b) {
                return $b->priority <=> $a->priority; // Sort from highest to lowest
            });
            $this->is_sorted = true;
        }

        foreach ($this->hooks as $hook)
        {
            try {
                $this->serviceManager->di->call($hook->closure, $parameters);
            } catch (CallFailedException $e) {
                throw new TriggerFailedException($this->name, $e);
            }
        }
    }
}