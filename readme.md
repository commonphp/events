# CommonPHP Events

A lightweight, PSR-14 compatible event dispatching library designed for simplicity and efficiency. It provides a global yet replaceable event dispatcher, supports prioritized listeners, and allows flexible event handling.

## Features

- **PSR-14 Compatible:** Implements the standard event dispatcher interface.
- **Simple Event Registration:** Easily register and dispatch events.
- **Prioritized Listeners:** Control execution order with priority levels.
- **Global or Dependency Injected:** Use globally or inject as needed.
- **Supports Stoppable Events:** Halt propagation when necessary.

## Installation

Install via Composer:

```bash
composer require comphp/events
```

## Usage

Create and dispatch events using the `EventDispatcher`.

```php
<?php
require 'vendor/autoload.php';

use Neuron\Events\EventDispatcher;
use Neuron\Events\AbstractEvent;

// Define an event
class UserRegisteredEvent extends AbstractEvent
{
    public function __construct(private string $username)
    {
        parent::__construct(['username' => $username]);
    }
}

// Initialize the dispatcher
$dispatcher = new EventDispatcher();

// Register a listener
$dispatcher->listen(UserRegisteredEvent::class, function (UserRegisteredEvent $event) {
    echo "User registered: " . $event->getPayload()['username'] . "\n";
});

// Dispatch the event
$dispatcher->dispatch(new UserRegisteredEvent('Tim'));
```

## Examples

Additional example scripts are provided in the `examples/` directory, demonstrating different use cases of event dispatching.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a record of changes.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to help out.

## Code of Conduct

This project is released under a Code of Conduct. Please review [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) for details.

## License

This project is licensed under the [MIT License](LICENSE.md). See the LICENSE file for more information.

