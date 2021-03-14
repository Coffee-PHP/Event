<?php

/**
 * EventRegistry.php
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

use CoffeePhp\Event\Contract\EventRegistryInterface;

use function spl_object_id;

/**
 * Class EventRegistry
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
final class EventRegistry implements EventRegistryInterface
{
    /**
     * A map of event object IDs to event objects, used to prevent garbage collection.
     *
     * @var array<int, object>
     */
    private array $events = [];

    /**
     * A map of event object IDs to an array of listeners.
     *
     * @var array<int, array<int, callable>>
     */
    private array $registry = [];

    /**
     * @inheritDoc
     */
    public function registerListenerForEvent(object $event, callable $listener): void
    {
        $objectId = spl_object_id($event);
        $this->events[$objectId] = $event; // Prevent garbage collection.
        $this->registry[$objectId][] = $listener;
    }

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        return $this->registry[spl_object_id($event)] ?? [];
    }
}
