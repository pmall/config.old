<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Ellipse\Config\ConfigServiceFactory;

describe('ConfigServiceFactory', function () {

    beforeEach(function () {

        $this->delegate = stub();

        $this->factory = new ConfigServiceFactory($this->delegate);

    });

    describe('->__invoke()', function () {

        it('should proxy the delegate', function () {

            $container = mock(ContainerInterface::class)->get();

            $this->delegate->with($container)->returns('value');

            $test = ($this->factory)($container);

            expect($test)->toEqual('value');

        });

    });

});
