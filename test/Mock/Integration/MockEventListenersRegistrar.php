<?php

/**
 * MockEventListenersRegistrar.php
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

namespace CoffeePhp\Event\Test\Mock\Integration;

use CoffeePhp\ComponentRegistry\Contract\ComponentRegistrarInterface;
use CoffeePhp\Event\Contract\EventRegistryInterface;
use CoffeePhp\Event\Test\Mock\Event\MockEvent;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener1;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener2;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener3;
use CoffeePhp\Event\Test\Mock\Event\MockEventListener4;

/**
 * Class MockEventListenersRegistrar
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 */
final class MockEventListenersRegistrar implements ComponentRegistrarInterface
{
    public function __construct(
        private EventRegistryInterface $registry,
        private MockEvent $event,
        private MockEventListener1 $listener1,
        private MockEventListener2 $listener2,
        private MockEventListener3 $listener3,
        private MockEventListener4 $listener4,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->registry->registerListenerForEvent($this->event, $this->listener1);
        $this->registry->registerListenerForEvent($this->event, $this->listener2);
        $this->registry->registerListenerForEvent($this->event, $this->listener3);
        $this->registry->registerListenerForEvent($this->event, $this->listener4);
    }
}
