<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Ellipse\Config\ConfigValue;
use Ellipse\Config\ConfigServiceFactory;

describe('ConfigValue', function () {

    describe('->__invoke()', function () {

        beforeEach(function () {

            $this->container = mock(ContainerInterface::class)->get();

        });

        context('when the value is not a config service factory', function () {

            it('should return the value', function () {

                $value = new ConfigValue('value');

                $test = $value($this->container);

                expect($test)->toEqual('value');

            });

        });

        context('when the value is a config service factory', function () {

            it('should proxy it', function () {

                $container = mock(ContainerInterface::class)->get();
                $factory = mock(ConfigServiceFactory::class);

                $value = new ConfigValue($factory->get());

                $factory->__invoke->with($container)->returns('value');

                $test = $value($container);

                expect($test)->toEqual('value');

            });

        });

    });

});
