<?php

/**
 * AbstractListenerTest.php
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

namespace CoffeePhp\Event\Test\Unit\Handling;


use CoffeePhp\Event\Handling\AbstractListener;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEvent;
use CoffeePhp\Event\Test\Mock\UnsuccessfulEvent\MockUnsuccessfulEventListener1;
use PHPUnit\Framework\TestCase;

use function get_class;
use function ob_clean;
use function ob_get_contents;
use function PHPUnit\Framework\assertSame;

use const PHP_EOL;

/**
 * Class AbstractListenerTest
 * @package coffeephp\event
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-09-03
 * @see AbstractListener
 */
final class AbstractListenerTest extends TestCase
{
    /**
     * @see AbstractListener::__invoke()
     */
    public function testInvoke(): void
    {
        $listener = new MockUnsuccessfulEventListener1();
        ob_get_contents();
        $listener(new MockUnsuccessfulEvent());
        $output = ob_get_contents();
        ob_clean();
        assertSame(get_class($listener) . PHP_EOL, $output);
    }
}
