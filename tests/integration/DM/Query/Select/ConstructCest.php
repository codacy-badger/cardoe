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
use Phalcon\DM\Query\Bind;
use Phalcon\DM\Query\Select;

class ConstructCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: __construct()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectConstruct(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - __construct()');

        $connection = $I->getConnection();
        $bind       = new Bind();
        $select     = new Select($connection, $bind);

        $I->assertInstanceOf(Select::class, $select);
    }
}