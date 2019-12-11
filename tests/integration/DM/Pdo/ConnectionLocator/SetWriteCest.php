<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\ConnectionLocator;

use IntegrationTester;

class SetWriteCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\ConnectionLocator :: setWrite()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionLocatorSetWrite(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\ConnectionLocator - setWrite()');

        $I->skipTest('Need implementation');
    }
}