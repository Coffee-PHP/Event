<?php

/**
 * EventListenerMapTest.php
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

namespace CoffeePhp\Event\Test\Unit\Data;


use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEvent;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener1;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener2;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener3;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEvent;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener1;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener2;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener3;
use PHPUnit\Framework\TestCase;

use function get_class;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * Class EventListenerMapTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 * @see EventListenerMap
 */
final class EventListenerMapTest extends TestCase
{
    /**
     * @see EventListenerMap::add()
     * @see EventListenerMap::get()
     * @see EventListenerMap::toArray()
     */
    public function testFunctionality(): void
    {
        $map = new EventListenerMap();
        $event = new MockSuccessfulEvent();
        $event2 = new MockUnsuccessfulEvent();
        $map->add($event, new MockSuccessfulEventListener1());
        $map->add($event, new MockSuccessfulEventListener2());
        $map->add($event, new MockSuccessfulEventListener3());
        $map->add($event2, new MockUnsuccessfulEventListener1());
        $map->add($event2, new MockUnsuccessfulEventListener2());
        $map->add($event2, new MockUnsuccessfulEventListener3());

        assertCount(
            3,
            $map->get($event)
        );
        assertCount(
            3,
            $map->get($event2)
        );

        assertInstanceOf(
            MockSuccessfulEventListener1::class,
            $map->get($event)[0]
        );
        assertInstanceOf(
            MockSuccessfulEventListener2::class,
            $map->get($event)[1]
        );
        assertInstanceOf(
            MockSuccessfulEventListener3::class,
            $map->get($event)[2]
        );

        assertInstanceOf(
            MockUnsuccessfulEventListener1::class,
            $map->get($event2)[0]
        );
        assertInstanceOf(
            MockUnsuccessfulEventListener2::class,
            $map->get($event2)[1]
        );
        assertInstanceOf(
            MockUnsuccessfulEventListener3::class,
            $map->get($event2)[2]
        );

        assertInstanceOf(
            MockSuccessfulEventListener1::class,
            $map->toArray()[get_class($event)][0]
        );
        assertInstanceOf(
            MockSuccessfulEventListener2::class,
            $map->toArray()[get_class($event)][1]
        );
        assertInstanceOf(
            MockSuccessfulEventListener3::class,
            $map->toArray()[get_class($event)][2]
        );

        assertInstanceOf(
            MockUnsuccessfulEventListener1::class,
            $map->toArray()[get_class($event2)][0]
        );
        assertInstanceOf(
            MockUnsuccessfulEventListener2::class,
            $map->toArray()[get_class($event2)][1]
        );
        assertInstanceOf(
            MockUnsuccessfulEventListener3::class,
            $map->toArray()[get_class($event2)][2]
        );
    }
}
