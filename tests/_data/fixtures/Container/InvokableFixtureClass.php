<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Container;

/**
 * Class MalleableFixtureClass
 *
 * @property string $name
 */
class InvokableFixtureClass
{
    /**
     * @var string
     */
    protected $name;

    public function __construct(string $name = 'seven')
    {
        $this->name = $name;
    }

    public function __invoke(string $value)
    {
        return $this->name . $value;
    }
}
