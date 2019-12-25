<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection\Decorated;

use Cardoe\DM\Pdo\Connection\Decorated;
use Cardoe\DM\Pdo\Profiler\Profiler;
use IntegrationTester;
use PDO;

class ConstructCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection\Decorated :: __construct()
     *
     * @since  2019-12-12
     */
    public function dMPdoConnectionDecoratedConstruct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection\Decorated - __construct()');

        $connection = new PDO(
            $I->getDatabaseDsn(),
            $I->getDatabaseUsername(),
            $I->getDatabasePassword(),
        );

        $decorated = new Decorated($connection);
        $decorated->connect();

        $I->assertTrue($decorated->isConnected());
        $I->assertInstanceOf(Profiler::class, $decorated->getProfiler());
        $I->assertSame($connection, $decorated->getAdapter());
    }
}