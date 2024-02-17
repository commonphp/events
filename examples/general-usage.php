<?php

require '../vendor/autoload.php';

use CommonPHP\Events\EventManager;
use CommonPHP\Events\ServiceProviders\EventManagerServiceProvider;
use CommonPHP\ServiceManagement\ServiceManager;

// Simulating the ServiceManager setup
$serviceManager = new ServiceManager();
$serviceManager->providers->registerProvider(EventManagerServiceProvider::class);

// Setting up the EventManager and registering it with the ServiceManager
$eventManager = $serviceManager->get(EventManager::class);

// DemoClass setup and usage
class DemoClass
{
    private $demoEvent;

    public function __construct(EventManager $events)
    {
        // Register the 'demo' event with the EventManager
        $this->demoEvent = $events->register('demo');
    }

    public function onDemo(callable $callback, int $priority = 0)
    {
        // Hook a callback to the 'demo' event
        $this->demoEvent->hook($callback, $priority);
    }

    public function triggerDemo()
    {
        // Trigger the 'demo' event, which will execute all hooked callbacks in order of their priority
        $this->demoEvent->trigger();
    }
}

// Instantiate DemoClass with the EventManager
$demo = new DemoClass($eventManager);

// Hook callbacks to the 'demo' event
$demo->onDemo(function () {
    echo "Demo event callback with priority 1\n";
}, 1);

$demo->onDemo(function () {
    echo "Demo event callback with priority -1 (executes last)\n";
}, -1);

$demo->onDemo(function () {
    echo "Demo event callback with priority 0 (executes second)\n";
}, 0);

// Trigger the 'demo' event
$demo->triggerDemo();
