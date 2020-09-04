<?php

/**
 * ListenerProviderTest.php
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

namespace CoffeePhp\Event\Test\Unit\Handling;


use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\Handling\ListenerProvider;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEvent;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener1;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener2;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener3;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;

/**
 * Class ListenerProviderTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-04
 * @see ListenerProvider
 */
final class ListenerProviderTest extends TestCase
{
    /**
     * @see ListenerProvider::getListenersForEvent()
     */
    public function testGetListenersForEvent(): void
    {
        $map = new EventListenerMap();
        $listenerProvider = new ListenerProvider($map);
        $event = new MockSuccessfulEvent();
        $map->add($event, new MockSuccessfulEventListener1());
        $map->add($event, new MockSuccessfulEventListener2());
        $map->add($event, new MockSuccessfulEventListener3());
        $listeners = [];
        foreach ($listenerProvider->getListenersForEvent($event) as $listener) {
            $listeners[] = $listener;
        }
        assertCount(3, $listeners);
    }
}
