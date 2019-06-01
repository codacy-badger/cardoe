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

class WithAddedHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withAddedHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithAddedHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withAddedHeader()');
        $data        = [
            'Accept' => ['text/html'],
        ];
        $request     = new ServerRequest('GET', null, [], 'php://input', $data);
        $newInstance = $request->withAddedHeader('Cache-Control', ['max-age=0']);

        $I->assertNotEquals($request, $newInstance);

        $expected = [
            'Accept' => ['text/html'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withAddedHeader() - merge
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithAddedHeaderMerge(UnitTester $I)
    {
        $data        = [
            'Accept' => ['text/html'],
        ];
        $request     = new ServerRequest('GET', null, [], 'php://input', $data);
        $newInstance = $request->withAddedHeader('Accept', ['text/json']);

        $I->assertNotEquals($request, $newInstance);

        $expected = [
            'Accept' => ['text/html'],
        ];
        $actual   = $request->getHeaders();
        $I->assertEquals($expected, $actual);

        $expected = [
            'Accept' => ['text/html', 'text/json'],
        ];
        $actual   = $newInstance->getHeaders();
        $I->assertEquals($expected, $actual);
    }
}