<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\ServerRequest;

use Phalcon\Http\Message\ServerRequest;
use UnitTester;

class GetRequestTargetCest
{
    /**
     * Tests Phalcon\Http\Message\ServerRequest :: getRequestTarget()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetRequestTarget(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getRequestTarget()');
        $request = new ServerRequest();

        $expected = '/';
        $actual   = $request->getRequestTarget();
        $I->assertEquals($expected, $actual);
    }
}
