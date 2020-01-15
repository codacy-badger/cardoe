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
use Phalcon\Http\JWT\Exceptions\UnsupportedAlgorithmException;
use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Signer\Hmac;
use UnitTester;

class GetSetPassphraseCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: getPassphrase()/setPassphrase()
     *
     * @throws ValidatorException
     * @throws UnsupportedAlgorithmException
     * @since  2019-12-19
     */
    public function httpJWTBuilderGetSetPassphrase(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - getPassphrase()/setPassphrase()');

        $signer  = new Hmac();
        $builder = new Builder($signer);

        $passphrase = '6U#5xK!uFmUtwRZ3SCLjC*K%i8f@4MNE';
        $return     = $builder->setPassphrase($passphrase);
        $I->assertInstanceOf(Builder::class, $return);
        $I->assertEquals($passphrase, $builder->getPassphrase());
    }

    /**
     * Unit Tests Phalcon\Http\JWT\Builder :: setPassphrase() - exception
     *
     * @since  2019-12-15
     */
    public function httpJWTBuilderSetPassphraseException(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Builder - setPassphrase() - exception');

        $I->expectThrowable(
            new ValidatorException(
                'Invalid passphrase (too weak)'
            ),
            function () {
                $signer  = new Hmac();
                $builder = new Builder($signer);
                $builder->setPassphrase('1234');
            }
        );
    }
}
