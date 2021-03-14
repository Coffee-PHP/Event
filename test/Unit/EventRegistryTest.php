<?php

/**
 * EventRegistryTest.php
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

use Closure;
use CoffeePhp\Event\EventRegistry;
use CoffeePhp\QualityTools\TestCase;
use stdClass;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

/**
 * Class EventRegistryTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 * @see EventRegistry
 */
final class EventRegistryTest extends TestCase
{
    private EventRegistry $registry;

    /**
     * @before
     */
    public function setupDependencies(): void
    {
        $this->registry = new EventRegistry();
    }

    /**
     * @see EventRegistry::registerListenerForEvent()
     * @see EventRegistry::getListenersForEvent()
     */
    public function testRegistrationAndRetrieval(): void
    {
        $event = new stdClass();
        assertEmpty($this->registry->getListenersForEvent($event));

        $listener1 = Closure::fromCallable(fn() => null);
        $listener2 = Closure::fromCallable(fn() => null);
        $listener3 = Closure::fromCallable(fn() => null);

        $this->registry->registerListenerForEvent($event, $listener1);
        assertSame([$listener1], $this->registry->getListenersForEvent($event));

        $this->registry->registerListenerForEvent($event, $listener2);
        assertSame([$listener1, $listener2], $this->registry->getListenersForEvent($event));

        $this->registry->registerListenerForEvent($event, $listener3);
        assertSame([$listener1, $listener2, $listener3], $this->registry->getListenersForEvent($event));

        $event = new stdClass();
        assertEmpty($this->registry->getListenersForEvent($event));
    }
}
