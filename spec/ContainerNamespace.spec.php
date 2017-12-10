<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Ellipse\Config\ConfigValue;
use Ellipse\Config\ContainerNamespace;

describe('ContainerNamespace', function () {

    beforeEach(function () {

        $this->namespace = new ContainerNamespace('namespace', [
            'v1',
            'v2',
            'k1' => 'v3',
            'k2' => 'v4',
            'k3' => ['k4' => 'v5', 'v6'],
            ['k5' => 'v7', 'v8'],
        ]);

    });

    describe('->__invoke()', function () {

        it('shoud return the anonymous values with the values contained in the container for the named values', function () {

            $container = mock(ContainerInterface::class);

            $container->get->with('namespace.k1')->returns('c1');
            $container->get->with('namespace.k2')->returns('c2');
            $container->get->with('namespace.k3')->returns('c3');

            $test = ($this->namespace)($container->get());

            expect($test)->toEqual([
                'v1',
                'v2',
                'k1' => 'c1',
                'k2' => 'c2',
                'k3' => 'c3',
                ['k5' => 'v7', 'v8'],
            ]);

        });

    });

    describe('->factories()', function () {

        it('should return an associative array of alias => service factory pairs to register in the container for this namespace', function () {

            $test = $this->namespace->factories();

            expect($test)->toEqual([
                'namespace.k1' => new ConfigValue('v3'),
                'namespace.k2' => new ConfigValue('v4'),
                'namespace.k3' => new ContainerNamespace('namespace.k3', ['k4' => 'v5', 'v6']),
                'namespace.k3.k4' => new ConfigValue('v5'),
            ]);

        });

    });

});
