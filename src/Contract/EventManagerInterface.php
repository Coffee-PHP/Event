<?php

/**
 * EventManagerInterface.php
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

namespace CoffeePhp\Event\Contract;

use CoffeePhp\Event\Contract\Data\EventInterface;
use CoffeePhp\Event\Contract\Data\EventListenerMapInterface;
use CoffeePhp\Event\Contract\Handling\EventDispatcherInterface;
use CoffeePhp\Event\Contract\Handling\ListenerInterface;
use CoffeePhp\Event\Contract\Handling\ListenerProviderInterface;
use CoffeePhp\Event\Exception\EventException;

/**
 * Interface EventManagerInterface
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
interface EventManagerInterface
{
    /**
     * Registers the provided listener
     * to the provided event.
     *
     * @param EventInterface $event
     * @param ListenerInterface $listener
     */
    public function register(EventInterface $event, ListenerInterface $listener): void;

    /**
     * Dispatches the given event.
     *
     * @param EventInterface $event
     * @throws EventException
     */
    public function dispatch(EventInterface $event): void;

    /**
     * Get the event listener map.
     *
     * @return EventListenerMapInterface
     */
    public function getEventListenerMap(): EventListenerMapInterface;

    /**
     * Get the event dispatcher instance.
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface;

    /**
     * Get the listener provider instance.
     *
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface;
}
