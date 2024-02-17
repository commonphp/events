<?php /** @noinspection PhpUnused */

/**
 * Manages the lifecycle of events including registration, de-registration, triggering, and hook management.
 *
 * Provides a centralized system to handle event-driven programming within applications, allowing for
 * dynamic event creation, subscription, and notification mechanisms. This class interfaces with the
 * ServiceManager for dependency injection and utilizes a registry pattern for managing events and their
 * hooks.
 *
 * @package CommonPHP\Events
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Events;

use Closure;
use CommonPHP\Events\Exceptions\DuplicateEventNameException;
use CommonPHP\Events\Exceptions\EmptyEventNameException;
use CommonPHP\Events\Exceptions\EventNotDefinedException;
use CommonPHP\Events\Exceptions\TriggerFailedException;
use CommonPHP\Events\Support\Event;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\ServiceManager;
use Override;

final class EventManager implements BootstrapperContract
{
    /** @var ServiceManager The service manager instance used for dependency injection. */
    private ServiceManager $serviceManager;

    /** @var Event[] Array of registered events. */
    private array $events = [];

    /**
     * @inheritDoc
     */
    #[Override] function bootstrap(ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Registers a new event with the given name.
     *
     * @param string $eventName The name of the event.
     * @return Event The newly created and registered event.
     * @throws DuplicateEventNameException
     * @throws EmptyEventNameException
     */
    public function register(string $eventName): Event
    {
        $name = $this->sanitizeEventName($eventName);
        if (isset($this->events[$name]))
        {
            throw new DuplicateEventNameException($eventName);
        }
        $this->events[$name] = new Event($this->serviceManager, $eventName);
        return $this->events[$name];
    }

    /**
     * Clears all hooks attached to a specific event.
     *
     * @param string $eventName The name of the event.
     * @throws EmptyEventNameException
     * @throws EventNotDefinedException
     */
    public function clear(string $eventName): void
    {
        $name = $this->sanitizeEventName($eventName);
        if (!isset($this->events[$name]))
        {
            throw new EventNotDefinedException($eventName);
        }
        $this->events[$name]->clear();
    }

    /**
     * De-registers an event, removing it and all attached hooks.
     *
     * @param string $eventName The name of the event.
     * @throws EmptyEventNameException
     * @throws EventNotDefinedException
     */
    public function deregister(string $eventName): void
    {
        $name = $this->sanitizeEventName($eventName);
        if (!isset($this->events[$name]))
        {
            throw new EventNotDefinedException($eventName);
        }
        $this->events[$name]->clear();
        unset($this->events[$name]);
    }

    /**
     * Retrieves an event by name.
     *
     * @param string $eventName The name of the event.
     * @throws EmptyEventNameException
     * @throws EventNotDefinedException
     */
    public function get(string $eventName): Event
    {
        $name = $this->sanitizeEventName($eventName);
        if (!isset($this->events[$name]))
        {
            throw new EventNotDefinedException($eventName);
        }
        return $this->events[$name];
    }

    /**
     * Attaches a hook to an event.
     *
     * @param string $eventName The name of the event.
     * @param callable|Closure $callback The callback to attach as a hook.
     * @param int $priority The priority of the hook.
     * @throws EmptyEventNameException
     * @throws EventNotDefinedException
     */
    public function hook(string $eventName, callable|Closure $callback, int $priority = 0): void
    {
        $this->get($eventName)->hook($callback, $priority);
    }

    /**
     * Triggers an event, executing all attached hooks.
     *
     * @param string $eventName The name of the event.
     * @param array $parameters Parameters to pass to each hook.
     * @throws EmptyEventNameException
     * @throws EventNotDefinedException
     * @throws TriggerFailedException
     */
    public function trigger(string $eventName, array $parameters = []): void
    {
        $this->get($eventName)->trigger($parameters);
    }

    /**
     * Checks if an event is registered.
     *
     * @param string $hookName The name of the event.
     * @return bool True if the event is registered, false otherwise.
     * @throws EmptyEventNameException
     */
    public function has(string $hookName): bool
    {
        $name = $this->sanitizeEventName($hookName);
        return isset($this->events[$name]);
    }

    /**
     * Sanitizes and validates an event name.
     *
     * @param string $hookName The name of the event.
     * @return string The sanitized event name.
     * @throws EmptyEventNameException
     */
    private function sanitizeEventName(string $hookName): string
    {
        $name = strtolower(trim($hookName));
        if ($name == '')
        {
            throw new EmptyEventNameException();
        }
        return $name;
    }
}