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

namespace Phalcon\Test\Unit\Http\JWT\Token\Token;

use Phalcon\Http\JWT\Token\Item;
use Phalcon\Http\JWT\Token\Signature;
use Phalcon\Http\JWT\Token\Token;
use UnitTester;

class GetSignatureCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Token\Token :: getSignature()
     *
     * @since  2019-12-22
     */
    public function httpJWTTokenTokenGetSignature(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Token\Token - getSignature()');

        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["aud" => ["valid-audience"]], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $I->assertInstanceOf(Signature::class, $token->getSignature());
        $I->assertEquals("signature-encoded", $token->getSignature()->getEncoded());
    }
}
