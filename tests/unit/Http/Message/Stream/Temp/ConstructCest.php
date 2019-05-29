<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream\Temp;

use Cardoe\Http\Message\Stream\Temp;
use Psr\Http\Message\StreamInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Temp :: __construct()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamTempConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Temp - __construct()');
        $request = new Temp();
        $class   = StreamInterface::class;
        $I->assertInstanceOf($class, $request);
    }
}