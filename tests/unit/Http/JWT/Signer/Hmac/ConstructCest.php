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

namespace Phalcon\Test\Unit\Http\JWT\Signer\Hmac;

use Phalcon\Http\JWT\Exceptions\UnsupportedAlgorithmException;
use Phalcon\Http\JWT\Signer\Hmac;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Signer\Hmac :: __construct()
     *
     * @since  2019-12-15
     */
    public function httpJWTSignerHmacConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Signer\Hmac - __construct()');

        $signer = new Hmac();
        $I->assertInstanceOf(Hmac::class, $signer);
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Signer\Hmac :: __construct() - exception
     *
     * @since  2019-12-15
     */
    public function httpJWTSignerHmacConstructException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Signer\Hmac - __construct() - exception');

        $I->expectThrowable(
            new UnsupportedAlgorithmException(
                'Unsupported HMAC algorithm'
            ),
            function () {
                $signer = new Hmac('unknown');
            }
        );
    }
}
