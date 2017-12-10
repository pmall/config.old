<?php declare(strict_types=1);

namespace Ellipse\Config;

use Interop\Container\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * The namespace.
     *
     * @var string
     */
    private $namespace;

    /**
     * The definitions under the namespace.
     *
     * @var array
     */
    private $definitions;

    /**
     * Set up a config service provider with the given namespace and the given
     * array of definitions it contains.
     *
     * @param string    $namespace
     * @param array     $definitions
     */
    public function __construct(string $namespace, array $definitions)
    {
        $this->namespace = $namespace;
        $this->definitions = $definitions;
    }

    /**
     * @inheritdoc
     */
    public function getFactories()
    {
        return (new ContainerNamespace($this->namespace, $this->definitions))->factories();
    }

    /**
     * @inheritdoc
     */
    public function getExtensions()
    {
        return [];
    }
}
