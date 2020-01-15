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

namespace Phalcon\Test\Unit\Http\Message\Request;

use Phalcon\Http\Message\Request;
use Phalcon\Http\Message\Stream;
use UnitTester;

class WithBodyCest
{
    /**
     * Tests Phalcon\Http\Message\Request :: withBody()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithBody(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withBody()');

        $fileName = dataDir('/assets/stream/bill-of-rights.txt');

        $stream = new Stream($fileName, 'rb');

        $request = new Request();

        $newInstance = $request->withBody($stream);

        $I->assertNotEquals($request, $newInstance);

        $I->openFile($fileName);

        $I->seeFileContentsEqual(
            $newInstance->getBody()
        );
    }
}
