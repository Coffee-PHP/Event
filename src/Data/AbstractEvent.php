<?php

/**
 * AbstractEvent.php
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

namespace CoffeePhp\Event\Data;

use CoffeePhp\Event\Contract\Data\EventInterface;

use function serialize;
use function unserialize;

/**
 * Class AbstractEvent
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 */
abstract class AbstractEvent implements EventInterface
{
    private bool $propagationStopped = false;

    /**
     * @inheritDoc
     */
    final public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * Stop the propagation of this event.
     */
    final protected function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    /**
     * @inheritDoc
     */
    final public function serialize(): string
    {
        return serialize(
            [
                'propagationStopped' => $this->propagationStopped
            ] + $this->toArray()
        );
    }

    /**
     * @inheritDoc
     * @noinspection UnserializeExploitsInspection
     */
    final public function unserialize($serialized): void
    {
        $data = (array)unserialize($serialized);
        $this->propagationStopped = (bool)$data['propagationStopped'];
        $this->fromArray($data);
    }

    /**
     * Set the class properties
     * from the given array.
     *
     * @param array $data
     */
    abstract protected function fromArray(array $data): void;

    /**
     * Convert the class properties
     * to an array.
     *
     * @return array
     */
    abstract protected function toArray(): array;
}
