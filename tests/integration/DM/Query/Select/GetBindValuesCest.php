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

namespace Phalcon\Test\Integration\DM\Query\Select;

use IntegrationTester;
use PDO;
use Phalcon\DM\Query\QueryFactory;

class GetBindValuesCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: getBindValues()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectGetBindValues(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - getBindValues()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        /**
         * BindValues - empty
         */
        $expected = [];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);

        /**
         * BindValues
         */
        $select->bindValues(
            [
                'one'   => 'two',
                'three' => 'four',
            ]
        );
        $expected = [
            'one'   => ['two', PDO::PARAM_STR],
            'three' => ['four', PDO::PARAM_STR],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);

        /**
         * BindValues - append
         */
        $select->bindValues(
            [
                'five' => 'six',
            ]
        );
        $expected = [
            'one'   => ['two', PDO::PARAM_STR],
            'three' => ['four', PDO::PARAM_STR],
            'five'  => ['six', PDO::PARAM_STR],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);

        /**
         * BindValue
         */
        $select->bindValue("seven", 8, PDO::PARAM_INT);
        $expected = [
            'one'   => ['two', PDO::PARAM_STR],
            'three' => ['four', PDO::PARAM_STR],
            'five'  => ['six', PDO::PARAM_STR],
            'seven' => [8, PDO::PARAM_INT],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);

        /**
         * BindInline
         */
        $select->bindInline(false, PDO::PARAM_BOOL);
        $expected = [
            'one'   => ['two', PDO::PARAM_STR],
            'three' => ['four', PDO::PARAM_STR],
            'five'  => ['six', PDO::PARAM_STR],
            'seven' => [8, PDO::PARAM_INT],
            '__1__' => [false, PDO::PARAM_BOOL],
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }
}
