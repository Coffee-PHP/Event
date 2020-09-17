<?php

/**
 * EventManager.php
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

namespace CoffeePhp\Event;

use CoffeePhp\Event\Contract\Data\EventInterface;
use CoffeePhp\Event\Contract\Data\EventListenerMapInterface;
use CoffeePhp\Event\Contract\EventManagerInterface;
use CoffeePhp\Event\Contract\Handling\EventDispatcherInterface;
use CoffeePhp\Event\Contract\Handling\ListenerInterface;
use CoffeePhp\Event\Contract\Handling\ListenerProviderInterface;
use CoffeePhp\Event\Exception\EventException;
use Throwable;

/**
 * Class EventManager
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
final class EventManager implements EventManagerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private EventListenerMapInterface $eventListenerMap;
    private ListenerProviderInterface $listenerProvider;

    /**
     * EventManager constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param ListenerProviderInterface $listenerProvider
     * @param EventListenerMapInterface $eventListenerMap
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EventListenerMapInterface $eventListenerMap,
        ListenerProviderInterface $listenerProvider
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventListenerMap = $eventListenerMap;
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @inheritDoc
     */
    public function register(EventInterface $event, ListenerInterface $listener): void
    {
        $this->eventListenerMap->add($event, $listener);
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event): void
    {
        try {
            $this->eventDispatcher->dispatch($event);
        } catch (EventException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new EventException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getEventListenerMap(): EventListenerMapInterface
    {
        return $this->eventListenerMap;
    }

    /**
     * @inheritDoc
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function getListenerProvider(): ListenerProviderInterface
    {
        return $this->listenerProvider;
    }
}
