<?php

/**
 * AbstractEventTest.php
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


use CoffeePhp\Event\Data\AbstractEvent;
use CoffeePhp\Event\Test\Mock\SuccessfulEvent\MockSuccessfulEvent;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function serialize;
use function uniqid;
use function unserialize;

/**
 * Class AbstractEventTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 * @see AbstractEvent
 */
final class AbstractEventTest extends TestCase
{
    /**
     * @see AbstractEvent::serialize()
     * @see AbstractEvent::unserialize()
     */
    public function testSerializationAndDeserialization(): void
    {
        $event = new MockSuccessfulEvent();

        assertEquals(
            $event,
            unserialize(serialize($event))
        );

        $event->addFinalData(uniqid('', true), uniqid('', true));

        assertEquals(
            $event,
            unserialize(serialize($event))
        );
    }
}
