<?php

/**
 * EventComponentRegistrar.php
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
 * @since 2020-09-03
 */

declare(strict_types=1);

namespace CoffeePhp\Event\Integration;


use CoffeePhp\ComponentRegistry\Contract\ComponentRegistrarInterface;
use CoffeePhp\Di\Contract\ContainerInterface;
use CoffeePhp\Event\Contract\Data\EventListenerMapInterface;
use CoffeePhp\Event\Contract\EventManagerInterface;
use CoffeePhp\Event\Contract\Handling\EventDispatcherInterface;
use CoffeePhp\Event\Contract\Handling\ListenerProviderInterface;
use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\EventManager;
use CoffeePhp\Event\Handling\EventDispatcher;
use CoffeePhp\Event\Handling\ListenerProvider;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProviderInterface;

/**
 * Class EventComponentRegistrar
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
final class EventComponentRegistrar implements ComponentRegistrarInterface
{
    /**
     * @inheritDoc
     */
    public function register(ContainerInterface $di): void
    {
        $di->bind(PsrEventDispatcherInterface::class, EventDispatcherInterface::class);
        $di->bind(EventDispatcherInterface::class, EventDispatcher::class);
        $di->bind(EventDispatcher::class, EventDispatcher::class);

        $di->bind(EventListenerMapInterface::class, EventListenerMap::class);
        $di->bind(EventListenerMap::class, EventListenerMap::class);

        $di->bind(PsrListenerProviderInterface::class, ListenerProviderInterface::class);
        $di->bind(ListenerProviderInterface::class, ListenerProvider::class);
        $di->bind(ListenerProvider::class, ListenerProvider::class);

        $di->bind(EventManagerInterface::class, EventManager::class);
        $di->bind(EventManager::class, EventManager::class);
    }
}
