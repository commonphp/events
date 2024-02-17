<?php

/**
 * Provides the EventManager as a service within the CommonPHP Service Management framework,
 * implementing the ServiceProviderContract and BootstrapperContract.
 *
 * This service provider ensures that the EventManager can be easily integrated and retrieved
 * through the ServiceManager, facilitating its use across an application. It supports the
 * dynamic nature of event-driven programming by allowing the EventManager to be bootstrapped
 * and utilized wherever needed.
 *
 * @package CommonPHP\Events\ServiceProviders
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\Events\ServiceProviders;

use CommonPHP\Events\EventManager;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;
use CommonPHP\ServiceManagement\ServiceManager;
use Override;

final class EventManagerServiceProvider implements ServiceProviderContract, BootstrapperContract
{
    /** @var ServiceManager The service manager instance for dependency management. */
    private ServiceManager $serviceManager;

    /**
     * @inheritDoc
     */
    #[Override] function bootstrap(ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function supports(string $className): bool
    {
        return $className === EventManager::class;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function handle(string $className, array $parameters = []): object
    {
        $result = $this->serviceManager->di->instantiate($className, $parameters);
        $result->bootstrap($this->serviceManager);
        return $result;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function isSingletonExpected(string $className): bool
    {
        return false;
    }
}