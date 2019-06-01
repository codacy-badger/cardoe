<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use UnitTester;

class GetHeadersCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: getHeaders()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeaders(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeaders()');

        $data = [
            'Cache-Control' => ['max-age=0'],
            'Accept'        => ['text/html'],
        ];

        $response = new Response('php://memory', 200, $data);

        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $response->getHeaders()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Response :: getHeaders() - empty
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseGetHeadersEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - getHeaders() - empty');

        $response = new Response();

        $I->assertEquals(
            [],
            $response->getHeaders()
        );
    }
}