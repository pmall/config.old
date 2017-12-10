<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Config\ConfigValue;
use Ellipse\Config\ContainerNamespace;
use Ellipse\Config\ConfigServiceProvider;

describe('ConfigServiceProvider', function () {

    beforeEach(function () {

        $this->provider = new ConfigServiceProvider('namespace', ['k1' => 'v1', 'k2' => 'v2']);

    });

    it('should implement ServiceProviderInterface', function () {

        expect($this->provider)->toBeAnInstanceOf(ServiceProviderInterface::class);

    });

    describe('->getFactories()', function () {

        beforeEach(function () {

            $this->factories = [
                'namespace.k1' => new ConfigValue('v1'),
                'namespace.k2' => new ConfigValue('v2'),
            ];

        });

        it('should create a new ContainerNamespace and proxy its ->factories() method', function () {

            $namespace = mock(ContainerNamespace::class);

            allow(ContainerNamespace::class)->toBe($namespace->get());

            $namespace->factories->returns($this->factories);

            $test = $this->provider->getFactories();

            expect($test)->toEqual($this->factories);

        });

        it('should create a new container namespace with the namespace and definitions', function () {

            $test = $this->provider->getFactories();

            expect($test)->toEqual($this->factories);

        });

    });

    describe('->getExtensions()', function () {

        it('should return an empty array', function () {

            $test = $this->provider->getExtensions();

            expect($test)->toEqual([]);

        });

    });

});
