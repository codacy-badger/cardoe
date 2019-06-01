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

class GetHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getHeader() - empty headers
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getHeader()');
        $data    = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];
        $request = new ServerRequest('GET', null, [], 'php://input', $data);

        $expected = ['text/html'];
        $actual   = $request->getHeader('accept');
        $I->assertEquals($expected, $actual);

        $actual = $request->getHeader('aCCepT');
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getHeader() - empty headers
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestGetHeaderEmptyHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getHeader() - empty headers');
        $request = new ServerRequest();

        $expected = [];
        $actual   = $request->getHeader('empty');
        $I->assertEquals($expected, $actual);
    }
}