<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use IntegrationTester;
use Phalcon\DM\Pdo\Connection;
use Phalcon\Test\Fixtures\Migrations\Invoices;

class FetchPairsCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: fetchPairs()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchPairs(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchPairs()');

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $invoice    = new Invoices($connection);

        $result = $invoice->insert($connection, 1);
        $I->assertEquals(1, $result);
        $result = $invoice->insert($connection, 2);
        $I->assertEquals(1, $result);
        $result = $invoice->insert($connection, 3);
        $I->assertEquals(1, $result);
        $result = $invoice->insert($connection, 4);
        $I->assertEquals(1, $result);

        $all = $connection->fetchPairs(
            'SELECT inv_id, inv_total from co_invoices'
        );
        $I->assertCount(4, $all);

        $expected = [
            1 => 101.00,
            2 => 102.00,
            3 => 103.00,
            4 => 104.00,
        ];

        $I->assertEquals($expected, $all);
    }
}
