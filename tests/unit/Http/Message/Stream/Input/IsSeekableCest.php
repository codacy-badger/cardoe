<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Stream\Input;

use Phalcon\Http\Message\Stream\Input;
use UnitTester;

class IsSeekableCest
{
    /**
     * Tests Phalcon\Http\Message\Stream\Input :: isSeekable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamInputIsSeekable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - isSeekable()');

        $stream = new Input();

        $I->assertTrue(
            $stream->isSeekable()
        );
    }
}
