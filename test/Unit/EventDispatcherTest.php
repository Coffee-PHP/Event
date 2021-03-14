<?php

/**
 * EventDispatcherTest.php
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

namespace CoffeePhp\Event\Test\Unit;

use CoffeePhp\Event\EventDispatcher;
use CoffeePhp\Event\EventRegistry;
use CoffeePhp\Event\Test\Mock\Event\MockEvent;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener1;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener2;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener3;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener4;
use CoffeePhp\QualityTools\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

/**
 * Class EventDispatcherTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 * @see EventDispatcher
 */
final class EventDispatcherTest extends TestCase
{
    private EventDispatcher $dispatcher;
    private MockEvent $event;

    /**
     * @before
     */
    public function setupDependencies(): void
    {
        $registry = new EventRegistry();
        $this->event = new MockEvent();
        $registry->registerListenerForEvent($this->event, new MockEventListener1());
        $registry->registerListenerForEvent($this->event, new MockEventListener2());
        $registry->registerListenerForEvent($this->event, new MockEventListener3());
        $registry->registerListenerForEvent($this->event, new MockEventListener4());
        $this->dispatcher = new EventDispatcher($registry);
    }

    /**
     * @see EventDispatcher::dispatch()
     */
    public function testDispatch(): void
    {
        assertEmpty($this->event->getData());
        $this->event->stop();
        $this->dispatcher->dispatch($this->event);
        assertEmpty($this->event->getData());
        $this->event->start();
        $this->dispatcher->dispatch($this->event);
        assertSame([1, 2, 3], $this->event->getData());
    }
}
