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

namespace Phalcon\Test\Unit\Http\JWT\Validator;

use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Validator;
use Phalcon\Test\Fixtures\Traits\JWTTrait;
use UnitTester;

class ValidateIssuedAtCest
{
    use JWTTrait;

    /**
     * Unit Tests Phalcon\Http\JWT\Validator :: validateIssuedAt()
     *
     * @since  2019-12-22
     */
    public function httpJWTValidatorValidateIssuedAt(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Validator - validateIssuedAt()');

        $token = $this->newToken();
        $I->expectThrowable(
            new ValidatorException(
                "Validation: the token cannot be used yet (future)"
            ),
            function () use ($token, $I) {
                $timestamp = strtotime(("-1 day"));
                $validator = new Validator($token);
                $I->assertInstanceOf(Validator::class, $validator);
                $validator->validateIssuedAt($timestamp);
            }
        );
    }
}
