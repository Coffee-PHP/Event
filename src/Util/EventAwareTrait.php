<?php

/**
 * EventAwareTrait.php
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

declare (strict_types=1);

namespace CoffeePhp\Event\Util;


use CoffeePhp\Event\Contract\Data\EventInterface;
use CoffeePhp\Event\Contract\Data\EventListenerMapInterface;
use CoffeePhp\Event\Contract\EventManagerInterface;
use CoffeePhp\Event\Contract\Handling\EventDispatcherInterface;
use CoffeePhp\Event\Contract\Handling\ListenerInterface;
use CoffeePhp\Event\Contract\Handling\ListenerProviderInterface;
use CoffeePhp\Event\Exception\EventException;

/**
 * Class EventAwareTrait
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-04
 * @property EventManagerInterface $eventManager
 */
trait EventAwareTrait
{
    /**
     * Registers the provided listener
     * to the provided event.
     *
     * @param EventInterface $event
     * @param ListenerInterface $listener
     */
    private function registerEvent(EventInterface $event, ListenerInterface $listener): void
    {
        $this->eventManager->register($event, $listener);
    }

    /**
     * Dispatches the given event.
     *
     * @param EventInterface $event
     * @throws EventException
     */
    private function dispatchEvent(EventInterface $event): void
    {
        $this->eventManager->dispatch($event);
    }

    /**
     * Get the event listener map.
     *
     * @return EventListenerMapInterface
     */
    private function getEventListenerMap(): EventListenerMapInterface
    {
        return $this->eventManager->getEventListenerMap();
    }

    /**
     * Get the event dispatcher instance.
     *
     * @return EventDispatcherInterface
     */
    private function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventManager->getEventDispatcher();
    }

    /**
     * Get the listener provider instance.
     *
     * @return ListenerProviderInterface
     */
    private function getListenerProvider(): ListenerProviderInterface
    {
        return $this->eventManager->getListenerProvider();
    }
}
