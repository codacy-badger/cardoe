<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\ServerRequestFactory;

use Phalcon\Http\Message\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class CreateServerRequestCest
{
    /**
     * Tests Phalcon\Http\Message\ServerRequestFactory :: createServerRequest()
     *
     * @since  2019-02-09
     */
    public function httpMessageServerRequestFactoryCreateServerRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequestFactory - createServerRequest()');

        $factory = new ServerRequestFactory();
        $request = $factory->createServerRequest('GET', '');
        $class   = ServerRequestInterface::class;
        $I->assertInstanceOf($class, $request);
    }
}
