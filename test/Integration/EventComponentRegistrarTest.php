<?php

/**
 * EventComponentRegistrarTest.php
 *
 * Copyright 2020 Danny Damsky
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
 * @since 2020-09-04
 */

declare(strict_types=1);

namespace CoffeePhp\Event\Test\Integration;


use CoffeePhp\Di\Container;
use CoffeePhp\Event\Contract\Data\EventListenerMapInterface;
use CoffeePhp\Event\Contract\EventManagerInterface;
use CoffeePhp\Event\Contract\Handling\EventDispatcherInterface;
use CoffeePhp\Event\Contract\Handling\ListenerProviderInterface;
use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\EventManager;
use CoffeePhp\Event\Handling\EventDispatcher;
use CoffeePhp\Event\Handling\ListenerProvider;
use CoffeePhp\Event\Integration\EventComponentRegistrar;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProviderInterface;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

/**
 * Class EventComponentRegistrarTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-04
 * @see EventComponentRegistrar
 */
final class EventComponentRegistrarTest extends TestCase
{
    /**
     * @see EventComponentRegistrar::register()
     */
    public function testRegister(): void
    {
        $di = new Container();
        $registrar = new EventComponentRegistrar();
        $registrar->register($di);

        assertTrue(
            $di->has(PsrEventDispatcherInterface::class)
        );
        assertTrue(
            $di->has(EventDispatcherInterface::class)
        );
        assertTrue(
            $di->has(EventDispatcher::class)
        );
        assertTrue(
            $di->has(EventListenerMapInterface::class)
        );
        assertTrue(
            $di->has(EventListenerMap::class)
        );
        assertTrue(
            $di->has(PsrListenerProviderInterface::class)
        );
        assertTrue(
            $di->has(ListenerProviderInterface::class)
        );
        assertTrue(
            $di->has(ListenerProvider::class)
        );
        assertTrue(
            $di->has(EventManagerInterface::class)
        );
        assertTrue(
            $di->has(EventManager::class)
        );

        assertInstanceOf(
            EventDispatcher::class,
            $di->get(EventDispatcherInterface::class)
        );
        assertSame(
            $di->get(EventDispatcher::class),
            $di->get(EventDispatcherInterface::class)
        );
        assertSame(
            $di->get(EventDispatcherInterface::class),
            $di->get(PsrEventDispatcherInterface::class)
        );

        assertInstanceOf(
            EventListenerMap::class,
            $di->get(EventListenerMapInterface::class)
        );
        assertSame(
            $di->get(EventListenerMap::class),
            $di->get(EventListenerMapInterface::class)
        );

        assertInstanceOf(
            ListenerProvider::class,
            $di->get(ListenerProviderInterface::class)
        );
        assertSame(
            $di->get(ListenerProvider::class),
            $di->get(ListenerProviderInterface::class)
        );
        assertSame(
            $di->get(ListenerProviderInterface::class),
            $di->get(PsrListenerProviderInterface::class)
        );

        assertInstanceOf(
            EventManager::class,
            $di->get(EventManagerInterface::class)
        );
        assertSame(
            $di->get(EventManager::class),
            $di->get(EventManagerInterface::class),
        );
    }
}
