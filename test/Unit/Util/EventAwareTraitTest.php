<?php

/**
 * EventAwareTraitTest.php
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

namespace CoffeePhp\Event\Test\Unit\Util;


use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\EventManager;
use CoffeePhp\Event\Handling\EventDispatcher;
use CoffeePhp\Event\Handling\ListenerProvider;
use CoffeePhp\Event\Test\Mock\MockEventAwareClass;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEvent;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener1;
use CoffeePhp\Event\Util\EventAwareTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class EventAwareTraitTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-04
 * @see EventAwareTrait
 */
final class EventAwareTraitTest extends TestCase
{
    public function testAccessibility(): void
    {
        $eventListenerMap = new EventListenerMap();
        $listenerProvider = new ListenerProvider($eventListenerMap);
        $eventDispatcher = new EventDispatcher($listenerProvider);
        $eventManager = new EventManager($eventDispatcher, $eventListenerMap, $listenerProvider);
        $event = new MockSuccessfulEvent();

        $eventAwareClass = new MockEventAwareClass($eventManager);
        $eventAwareClass->register($event, new MockSuccessfulEventListener1());
        $eventAwareClass->dispatch($event);

        self::assertArrayHasKey(
            MockSuccessfulEventListener1::class,
            unserialize($event->serialize())['arbitraryData']
        );
    }
}
