<?php declare(strict_types=1);

namespace Ellipse\Config;

use Psr\Container\ContainerInterface;

class ConfigServiceFactory
{
    /**
     * The delegate.
     *
     * @var callable
     */
    private $delegate;

    /**
     * Set up a config service factory with the given delegate.
     *
     * @param callable $delegate
     */
    public function __construct(callable $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Proxy the delegate.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        return ($this->delegate)($container);
    }
}
