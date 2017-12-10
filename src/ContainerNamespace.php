<?php declare(strict_types=1);

namespace Ellipse\Config;

use Psr\Container\ContainerInterface;

class ContainerNamespace
{
    /**
     * The container namespace.
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
     * Set up a container namespace with the given namespace and the given array
     * of definitions it contains.
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
     * Return the annonymous values among the given definitions.
     *
     * @param array $definitions
     * @return array
     */
    private function annonymousValues(array $definitions): array
    {
        return array_filter($definitions, 'is_int', ARRAY_FILTER_USE_KEY);
    }

    /**
     * Return the named values among the given definitions.
     *
     * @param array $definitions
     * @return array
     */
    private function namedValues(array $definitions): array
    {
        return array_filter($definitions, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    /**
     * Return all the annonymous values under the namespace merged with the
     * values contained in the container for the named values.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @return array
     */
    public function __invoke(ContainerInterface $container): array
    {
        $annon = $this->annonymousValues($this->definitions);
        $named = $this->namedValues($this->definitions);

        $aliases = array_keys($named);

        return array_reduce($aliases, function (array $values, string $alias) use ($container) {

            $namespaced = $this->namespace . '.' . $alias;

            return array_merge($values, [$alias => $container->get($namespaced)]);

        }, $annon);
    }

    /**
     * Return an associative array of alias => service factory pairs to register
     * in the container for this namespace.
     *
     * @return array
     */
    public function factories(): array
    {
        $named = $this->namedValues($this->definitions);

        $aliases = array_keys($named);

        return array_reduce($aliases, function (array $factories, string $alias) {

            $namespaced = $this->namespace . '.' . $alias;
            $value = $this->definitions[$alias];

            if (is_array($value)) {

                $namespace = new ContainerNamespace($namespaced, $value);

                return array_merge($factories, [$namespaced => $namespace], $namespace->factories());

            }

            return array_merge($factories, [$namespaced => new ConfigValue($value)]);

        }, []);
    }
}
