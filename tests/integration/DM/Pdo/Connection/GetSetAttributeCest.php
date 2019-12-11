<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use PDO;

class GetSetAttributeCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getAttribute()/setAttribute()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetSetAttribute(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getAttribute()/setAttribute()');

        $I->assertEquals(
            PDO::ERRMODE_EXCEPTION,
            $this->connection->getAttribute(PDO::ATTR_ERRMODE)
        );

        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_WARNING
        );

        $I->assertEquals(
            PDO::ERRMODE_WARNING,
            $this->connection->getAttribute(PDO::ATTR_ERRMODE)
        );
    }
}