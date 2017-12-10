<?php declare(strict_types=1);

namespace Ellipse\Config;

use Psr\Container\ContainerInterface;

class ConfigValue
{
    /**
     * The configuration value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Set up a config value with the given value.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Return the value as a container service factory.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        if ($this->value instanceof ConfigServiceFactory) {

            return ($this->value)($container);

        }

        return $this->value;
    }
}
