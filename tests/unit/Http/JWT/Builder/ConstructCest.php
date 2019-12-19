<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Builder;

use Phalcon\Http\JWT\Builder;
use Phalcon\Http\JWT\Validator;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: __construct()
     *
     * @since  2019-12-19
     */
    public function httpJWTBuilderConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - __construct()');

        $validator = new Validator();
        $builder   = new Builder($validator);

        $I->assertInstanceOf(Builder::class, $builder);
    }
}
