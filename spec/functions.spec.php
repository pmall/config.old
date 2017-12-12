<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use function Ellipse\Config\alias;
use function Ellipse\Config\resolver;
use Ellipse\Config\ConfigServiceFactory;

describe('alias', function () {

    it('should return a new service factory proxying the given alias', function () {

        $container = mock(ContainerInterface::class);

        $container->get->with('alias')->returns('value');

        $test = alias('alias');

        expect($test)->toBeAnInstanceOf(ConfigServiceFactory::class);
        expect($test($container->get()))->toEqual('value');

    });

});

describe('resolver', function () {

    it('should return a new service factory producing a callable proxying the given alias', function () {

        $container = mock(ContainerInterface::class);

        $container->get->with('alias')->returns('value');

        $test = resolver('alias');

        expect($test)->toBeAnInstanceOf(ConfigServiceFactory::class);
        expect($test($container->get()))->toBeAnInstanceOf(Closure::class);
        expect($test($container->get())())->toEqual('value');

    });

});
