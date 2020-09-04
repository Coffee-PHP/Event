<?php

/**
 * EventManagerTest.php
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

namespace CoffeePhp\Event\Test\Unit;


use CoffeePhp\Event\Data\EventListenerMap;
use CoffeePhp\Event\EventManager;
use CoffeePhp\Event\Exception\EventException;
use CoffeePhp\Event\Handling\EventDispatcher;
use CoffeePhp\Event\Handling\ListenerProvider;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEvent;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener1;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener2;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEventListener3;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEvent;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener1;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener2;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener3;
use PHPUnit\Framework\TestCase;

use function ob_clean;
use function ob_get_contents;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertArrayNotHasKey;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

use const PHP_EOL;

/**
 * Class EventManagerTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-04
 * @see EventManager
 */
final class EventManagerTest extends TestCase
{
    /**
     * @see EventManager::register()
     * @see EventManager::dispatch()
     */
    public function testRegisterAndDispatchSuccess(): void
    {
        $eventListenerMap = new EventListenerMap();
        $listenerProvider = new ListenerProvider($eventListenerMap);
        $eventDispatcher = new EventDispatcher($listenerProvider);
        $eventManager = new EventManager($eventDispatcher, $eventListenerMap, $listenerProvider);
        $event = new MockSuccessfulEvent();
        $eventManager->register($event, new MockSuccessfulEventListener1());
        $eventManager->register($event, new MockSuccessfulEventListener2());
        $eventManager->register($event, new MockSuccessfulEventListener3());
        $eventManager->dispatch($event);

        $eventData = unserialize($event->serialize())['arbitraryData'];
        assertArrayHasKey(
            MockSuccessfulEventListener1::class,
            $eventData
        );
        assertArrayHasKey(
            MockSuccessfulEventListener2::class,
            $eventData
        );
        assertArrayNotHasKey(
            MockSuccessfulEventListener3::class,
            $eventData
        );
    }

    /**
     * @see EventManager::register()
     * @see EventManager::dispatch()
     */
    public function testRegisterAndDispatchError(): void
    {
        $eventListenerMap = new EventListenerMap();
        $listenerProvider = new ListenerProvider($eventListenerMap);
        $eventDispatcher = new EventDispatcher($listenerProvider);
        $eventManager = new EventManager($eventDispatcher, $eventListenerMap, $listenerProvider);
        $event = new MockUnsuccessfulEvent();
        $eventManager->register($event, new MockUnsuccessfulEventListener1());
        $eventManager->register($event, new MockUnsuccessfulEventListener2());
        $eventManager->register($event, new MockUnsuccessfulEventListener3());

        ob_get_contents();
        try {
            $eventManager->dispatch($event);
            assertTrue(false);
        } catch (EventException $e) {
            assertTrue(true);
        }
        $output = ob_get_contents();
        ob_clean();

        assertSame(
            MockUnsuccessfulEventListener1::class . PHP_EOL . MockUnsuccessfulEventListener2::class . PHP_EOL,
            $output
        );
    }
}
