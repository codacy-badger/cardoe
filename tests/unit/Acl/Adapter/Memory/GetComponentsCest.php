<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use Cardoe\Acl\Adapter\Memory;
use Cardoe\Acl\Component;
use UnitTester;

class GetComponentsCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getComponents()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetComponents(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getComponents()');

        $acl = new Memory();

        $component1 = new Component('Posts');
        $component2 = new Component('Tags');

        $acl->addComponent($component1, ['index']);
        $acl->addComponent($component2, ['index']);


        $expected = [$component1, $component2];

        $I->assertEquals(
            $expected,
            $acl->getComponents()
        );
    }
}