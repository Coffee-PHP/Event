<?php

/**
 * SuccessfulEventListener3.php
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

namespace CoffeePhp\Event\Test\Mock\SuccessfulEvent;


use CoffeePhp\Event\Handling\AbstractListener;

/**
 * Class SuccessfulEventListener3
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
final class MockSuccessfulEventListener3 extends AbstractListener
{

    /**
     * @inheritDoc
     * @param MockSuccessfulEvent $event
     */
    protected function handle(object $event): void
    {
        $event->addData(static::class, static::class);
    }
}
