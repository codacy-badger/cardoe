<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\RequestFactory;

use Cardoe\Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use UnitTester;

class CreateRequestCest
{
    /**
     * Tests Cardoe\Http\Message\RequestFactory :: createRequest()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestFactoryCreateRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Message\RequestFactory - createRequest()');

        $factory = new RequestFactory();

        $request = $factory->createRequest('GET', 'https://dev.phalcon.ld');

        $I->assertInstanceOf(
            RequestInterface::class,
            $request
        );
    }
}