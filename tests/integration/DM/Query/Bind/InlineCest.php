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

namespace Phalcon\Test\Integration\DM\Query\Bind;

use IntegrationTester;
use PDO;
use Phalcon\DM\Query\Bind;

class InlineCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Bind :: inline()
     *
     * @since  2020-01-20
     */
    public function dMQueryBindInline(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Bind - inline()');

        $bind = new Bind();

        $expected = [];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);

        $bind->inline("one");

        $expected = [
            "__1__" => ["one", 2]
        ];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);

        $bind->inline(true, PDO::PARAM_BOOL);

        $expected = [
            "__1__" => ["one", 2],
            "__2__" => [1, 5],
        ];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);

        $bind->inline(["six", "seven", 8, 9]);

        $expected = [
            "__1__" => ["one", 2],
            "__2__" => [1, 5],
            "__3__" => ["six", 2],
            "__4__" => ["seven", 2],
            "__5__" => [8, 1],
            "__6__" => [9, 1],
        ];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);
    }
}
