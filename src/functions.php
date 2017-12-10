<?php declare(strict_types=1);

namespace Ellipse\Config;

use Psr\Container\ContainerInterface;

function alias(string $alias) {

    return new ConfigServiceFactory(function (ContainerInterface $container) use ($alias) {

        return $container->get($alias);

    });

};
