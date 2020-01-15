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

namespace Phalcon\Test\Unit\Http\JWT\Builder;

use Phalcon\Http\JWT\Builder;
use Phalcon\Http\JWT\Signer\Hmac;
use UnitTester;

class GetSetContentTypeCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getContentType()/setContentType()
     *
     * @since  2019-12-19
     */
    public function httpJWTBuilderGetSetContentType(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getContentType()/setContentType()');

        $signer  = new Hmac();
        $builder = new Builder($signer);

        $I->assertNull($builder->getContentType());

        $builder->setContentType('abcde');
        $I->assertEquals('abcde', $builder->getContentType());
    }
}
