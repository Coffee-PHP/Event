<?php

/**
 * MockEvent.php
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

namespace CoffeePhp\Event\Test\Mock\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use Serializable;

use function serialize;
use function unserialize;

/**
 * Class MockEvent
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2021-03-14
 */
final class MockEvent implements StoppableEventInterface, Serializable
{
    private bool $propagationStopped = false;

    /**
     * @var array<int, int>
     */
    private array $data = [];

    /**
     * @param int $value
     */
    public function addData(int $value): void
    {
        $this->data[] = $value;
    }

    /**
     * @return array<int, int>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return serialize(
            [
                'propagationStopped' => $this->propagationStopped,
                'data' => $this->data,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void
    {
        [
            'propagationStopped' => $this->propagationStopped,
            'data' => $this->data,
        ] = (array)unserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function start(): void
    {
        $this->propagationStopped = false;
    }

    public function stop(): void
    {
        $this->propagationStopped = true;
    }
}
