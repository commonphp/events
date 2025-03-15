<?php

namespace Neuron\Events;

use Neuron\Events\Exceptions\InvalidEventException;
use Neuron\Events\Exceptions\InvalidListenerException;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use SplPriorityQueue;

/**
 * Handles event registration and dispatching.
 * Implements PSR-14 EventDispatcherInterface and ListenerProviderInterface.
 */
final class EventDispatcher implements EventDispatcherInterface, ListenerProviderInterface
{
    /** @var array<class-string<EventInterface>, SplPriorityQueue<callable(EventInterface): void>> Stores registered event listeners grouped by event class. */
    private array $listeners = [];

    /**
     * Registers an event listener.
     *
     * @param string $event Event class name
     * @param callable(EventInterface): void|object $listener Event listener callback or object
     * @param int $priority Listener execution priority
     * @return void
     * @throws InvalidEventException
     * @throws InvalidListenerException
     */
    public function listen(string $event, callable|object $listener, int $priority = 0): void
    {
        if (!class_exists($event) || !in_array(EventInterface::class, class_implements($event))) {
            throw new InvalidEventException($event);
        }
        $isListenerObject = !is_callable($listener);
        if ($isListenerObject && (!class_exists($listener) || !($listener instanceof ListenerInterface))) {
            throw new InvalidListenerException(get_class($listener));
        }
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = new SplPriorityQueue();
        }
        $this->listeners[$event]->insert(
            $isListenerObject ? [$listener, 'handle'] : $listener,
            $priority
        );
    }

    /**
     * Dispatches an event to registered listeners.
     *
     * @param EventInterface $event Event instance
     * @return EventInterface
     * @noinspection PhpDocSignatureInspection
     * @throws InvalidEventException
     */
    public function dispatch(object $event): object
    {
        if (!($event instanceof EventInterface)) {
            throw new InvalidEventException(get_class($event));
        }
        $callbacks = $this->getListenersForEvent($event);
        foreach ($callbacks as $callback) {
            $callback($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }
        return $event;
    }

    /**
     * Return all listeners for a specific event
     *
     * @param EventInterface $event Event instance
     * @return iterable<callable(EventInterface): void>
     * @noinspection PhpDocSignatureInspection
     */
    public function getListenersForEvent(object $event): iterable
    {
        $class = get_class($event);

        if (!isset($this->listeners[$class])) {
            $this->listeners[$class] = new SplPriorityQueue();
        }
        /** @var callable(EventInterface): void [] $callbacks */
        return $this->listeners[$class];
    }
}