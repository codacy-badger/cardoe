<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Link\Link;

use Phalcon\Html\Link\Link;
use UnitTester;

class GetRelsCest
{
    /**
     * Tests Phalcon\Html\Link\Link :: getRels()
     *
     * @since  2019-06-15
     */
    public function htmlLinkLinkGetRels(UnitTester $I)
    {
        $I->wantToTest('Link\Link - getRels()');

        $href = 'https://dev.cardoe.ld';
        $link = new Link('payment', $href);

        $expected = ['payment'];
        $I->assertEquals($expected, $link->getRels());
    }
}