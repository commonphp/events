# CommonPHP Event Management Library

The CommonPHP Event Management Library offers a powerful and flexible system to handle event-driven programming within PHP applications. It provides mechanisms for event registration, de-registration, triggering, and dynamic hook management.

## Features

- **Event Registration & Deregistration**: Easily register and deregister events within your application.
- **Dynamic Hook Management**: Attach and manage callbacks (hooks) to events with support for priority ordering.
- **Event Triggering**: Trigger events dynamically, executing all attached hooks in priority order.
- **Exception Handling**: Robust exception handling for event-related operations, ensuring clear error reporting and resolution.
- **Service Manager Integration**: Seamlessly integrates with the CommonPHP Service Management framework for dependency management.

## Installation

Use Composer to install the Event Management Library into your project:

```bash
composer require comphp/events
```

## Basic Usage

To get started with the CommonPHP Event Management Library, please refer to the example provided in the `examples/general-usage.php` file within the library. This example demonstrates how to set up the `EventManager`, register events, attach hooks with callbacks, and trigger events within your application.

The example covers essential functionalities such as event registration, hook management, and event triggering, showcasing the library's integration with the CommonPHP Service Management framework for comprehensive event-driven programming.

```php
// Sample snippet from examples/general-usage.php

require '../vendor/autoload.php';

use CommonPHP\Events\EventManager;
use CommonPHP\Events\ServiceProviders\EventManagerServiceProvider;
use CommonPHP\ServiceManagement\ServiceManager;

// Simulating the ServiceManager setup
$serviceManager = new ServiceManager();
$serviceManager->providers->registerProvider(EventManagerServiceProvider::class);

// Setting up the EventManager and registering it with the ServiceManager
$eventManager = $serviceManager->get(EventManager::class);

// Example usage of EventManager within a DemoClass
class DemoClass {
    // Implementation details...
}

// For full example, please refer to examples/general-usage.php
```

For a complete and runnable example, including event deregistration and exception handling, please refer to the provided file. This will give you a practical understanding of how to integrate and utilize the event management capabilities in your projects.

## Advanced Usage

The library also supports advanced features like event de-registration, priority-based hook execution, and exception handling for robust event management. For more detailed examples, refer to the `/examples` directory.

## Contributing

Contributions to the CommonPHP Event Management Library are welcome. Please refer to the contributing guidelines for more information on how to submit pull requests, report issues, or request features.

## License

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).