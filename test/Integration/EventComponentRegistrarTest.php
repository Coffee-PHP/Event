<?php

/**
 * EventComponentRegistrarTest.php
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
use CoffeePhp\Event\Contract\EventRegistryInterface;
use CoffeePhp\Event\EventDispatcher;
use CoffeePhp\Event\EventRegistry;
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
 * @since 2021-03-14
 * @see EventComponentRegistrar
 */
final class EventComponentRegistrarTest extends TestCase
{
    private Container $di;
    private ComponentRegistry $registry;

    /**
     * @before
     */
    public function setupDependencies(): void
    {
        $this->di = new Container();
        $this->registry = new ComponentRegistry($this->di);
    }

    /**
     * @see EventComponentRegistrar::register()
     */
    public function testRegister(): void
    {
        $this->registry->register(EventComponentRegistrar::class);

        assertTrue($this->di->has(EventDispatcher::class));
        assertTrue($this->di->has(PsrEventDispatcherInterface::class));
        assertTrue($this->di->has(EventRegistry::class));
        assertTrue($this->di->has(PsrListenerProviderInterface::class));
        assertTrue($this->di->has(EventRegistryInterface::class));

        assertInstanceOf(EventDispatcher::class, $this->di->get(EventDispatcher::class));
        assertSame($this->di->get(EventDispatcher::class), $this->di->get(PsrEventDispatcherInterface::class));

        assertInstanceOf(EventRegistry::class, $this->di->get(EventRegistry::class));
        assertSame($this->di->get(EventRegistry::class), $this->di->get(EventRegistryInterface::class));
        assertSame($this->di->get(EventRegistry::class), $this->di->get(PsrListenerProviderInterface::class));
    }
}
