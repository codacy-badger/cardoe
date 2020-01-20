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
use Phalcon\DM\Query\QueryFactory;

class WhereEqualsCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: whereEquals()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectWhereEquals(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - whereEquals()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->whereEquals(
                [
                    'inv_id'     => [1, 2, 3],
                    'inv_cst_id' => null,
                    'inv_title'  => 'ACME',
                    'inv_created_at = NOW()'
                ]
            )
        ;

        $expected = "SELECT * "
            . "FROM co_invoices "
            . "WHERE inv_id IN (:__1__, :__2__, :__3__) "
            . "AND inv_cst_id IS NULL "
            . "AND inv_title = :__4__ "
            . "AND inv_created_at = NOW()";
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}
