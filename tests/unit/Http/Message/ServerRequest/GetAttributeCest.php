<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class GetAttributeCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getAttribute()
     *
     * @since  2019-02-11
     */
    public function httpMessageServerRequestGetAttribute(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getAttribute()');

        $request = (new ServerRequest())
            ->withAttribute('one', 'two')
            ->withAttribute('three', 'four')
        ;

        $I->assertEquals(
            'two',
            $request->getAttribute('one')
        );
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getAttribute() - unknown
     *
     * @since  2019-02-11
     */
    public function httpMessageServerRequestGetAttributeUnknown(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getAttribute() - unknown');

        $request = (new ServerRequest())
            ->withAttribute('one', 'two')
            ->withAttribute('three', 'four')
        ;

        $I->assertEquals(
            '',
            $request->getAttribute('unknown')
        );
    }
}
