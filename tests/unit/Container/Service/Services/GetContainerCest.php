<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Services;

use UnitTester;

class GetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: getContainer()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesGetContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - getContainer()');

        $I->skipTest('Need implementation');
    }
}