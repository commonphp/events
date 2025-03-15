<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace NeuronTests\Events;

use PHPUnit\Framework\TestCase;
use Neuron\Events\EventDispatcher;
use Neuron\Events\EventInterface;
use Neuron\Events\ListenerInterface;
use Neuron\Events\Exceptions\InvalidEventException;
use Psr\EventDispatcher\StoppableEventInterface;
use stdClass;

class EventDispatcherTest extends TestCase
{
    private EventDispatcher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new EventDispatcher();
    }

    public function testCanRegisterAndDispatchEvent(): void
    {
        $mockEvent = new class implements EventInterface {
            public function getPayload(): array { return ['key' => 'value']; }
        };

        $called = false;
        $this->dispatcher->listen(get_class($mockEvent), function (EventInterface $event) use (&$called) {
            $called = true;
            $this->assertSame(['key' => 'value'], $event->getPayload());
        });

        $this->dispatcher->dispatch($mockEvent);
        $this->assertTrue($called, 'Listener was not called.');
    }

    public function testStopsPropagationWhenStoppable(): void
    {
        $mockEvent = new class implements EventInterface, StoppableEventInterface {
            private bool $stopped = false;
            public function getPayload(): array { return []; }
            public function isPropagationStopped(): bool { return $this->stopped; }
            public function stopPropagation(): void { $this->stopped = true; }
        };

        $calledFirst = false;
        $calledSecond = false;

        $this->dispatcher->listen(get_class($mockEvent), function (StoppableEventInterface $event) use (&$calledFirst) {
            $calledFirst = true;
            $event->stopPropagation();
        }, 1);

        $this->dispatcher->listen(get_class($mockEvent), function () use (&$calledSecond) {
            $calledSecond = true;
        });

        $this->dispatcher->dispatch($mockEvent);

        $this->assertTrue($calledFirst, 'First listener was not called.');
        $this->assertFalse($calledSecond, 'Second listener was called even though propagation was stopped.');
    }

    public function testThrowsExceptionForInvalidEvent(): void
    {
        $this->expectException(InvalidEventException::class);
        $this->dispatcher->dispatch(new stdClass());
    }

    public function testCanRegisterListenerObject(): void
    {
        $mockEvent = new class implements EventInterface {
            public function getPayload(): array { return ['foo' => 'bar']; }
        };

        $listener = new class implements ListenerInterface {
            public bool $called = false;
            public function handle(EventInterface $event): void
            { $this->called = true; }
        };

        $this->dispatcher->listen(get_class($mockEvent), [$listener, 'handle']);
        $this->dispatcher->dispatch($mockEvent);
        $this->assertTrue($listener->called, 'Listener object was not called.');
    }
}
