<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class WithParsedBodyCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withParsedBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithParsedBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withParsedBody()');
        $request     = new ServerRequest();
        $newInstance = $request->withParsedBody('something');

        $I->assertNotEquals($request, $newInstance);

        $expected = null;
        $actual   = $request->getParsedBody();
        $I->assertEquals($expected, $actual);

        $expected = 'something';
        $actual   = $newInstance->getParsedBody();
        $I->assertEquals($expected, $actual);
    }
}
