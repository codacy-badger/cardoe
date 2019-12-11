<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use IntegrationTester;

class FetchAllCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchAll()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchAll(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchAll()');

        /** @var Connection $connection */
        $connection = $I->getConnection();

        $result = $I->getNewInvoice($connection, 1);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 2);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 3);
        $I->assertEquals(1, $result);
        $result = $I->getNewInvoice($connection, 4);
        $I->assertEquals(1, $result);

        $all = $connection->fetchAll(
            'SELECT * from co_invoices'
        );
        $I->assertCount(4, $all);

        $I->assertEquals(1, $all[0]['inv_id']);
        $I->assertEquals(2, $all[1]['inv_id']);
        $I->assertEquals(3, $all[2]['inv_id']);
        $I->assertEquals(4, $all[3]['inv_id']);
    }
}
