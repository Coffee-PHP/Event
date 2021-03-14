<?php

/**
 * EventIntegrationTest.php
 *
 * Copyright 2021 Danny Damsky
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 */

declare(strict_types=1);

namespace CoffeePhp\Event\Test\Integration;

use CoffeePhp\ComponentRegistry\ComponentRegistry;
use CoffeePhp\Di\Container;
use CoffeePhp\Di\Contract\ContainerInterface;
use CoffeePhp\Event\Integration\EventComponentRegistrar;
use CoffeePhp\Event\Test\Mock\Event\MockEvent;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener1;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener2;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener3;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener4;
use CoffeePhp\Event\Test\Mock\Integration\MockEventListenersRegistrar;
use CoffeePhp\Event\Test\Mock\Integration\MockEventsComponentRegistrar;
use CoffeePhp\Event\Test\Mock\Integration\MockListenersComponentRegistrar;
use CoffeePhp\QualityTools\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;

use function PHPUnit\Framework\assertSame;

/**
 * Class EventIntegrationTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 * @see MockEventsComponentRegistrar
 * @see MockListenersComponentRegistrar
 * @see MockEventListenersRegistrar
 */
final class EventIntegrationTest extends TestCase
{
    private ContainerInterface $di;

    /**
     * @before
     */
    public function setupDependencies(): void
    {
        $this->di = new Container();
        $registry = new ComponentRegistry($this->di);
        $registry->register(EventComponentRegistrar::class);
        $registry->register(MockEventsComponentRegistrar::class);
        $registry->register(MockListenersComponentRegistrar::class);
        $registry->register(MockEventListenersRegistrar::class);
    }

    public function testEventIntegration(): void
    {
        /** @var MockEvent $successfulEvent */
        $successfulEvent = $this->di->get(MockEvent::class);

        /** @var ListenerProviderInterface $listenerProvider */
        $listenerProvider = $this->di->get(ListenerProviderInterface::class);

        $listeners = $listenerProvider->getListenersForEvent($successfulEvent);
        assertSame(
            $listeners,
            [
                $this->di->get(MockEventListener1::class),
                $this->di->get(MockEventListener2::class),
                $this->di->get(MockEventListener3::class),
                $this->di->get(MockEventListener4::class),
            ]
        );
    }
}
