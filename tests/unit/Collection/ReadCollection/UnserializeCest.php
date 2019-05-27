<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\ReadCollection;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Collection :: serialize()
     *
     * @since  2018-11-13
     */
    public function collectionSerialize(UnitTester $I)
    {
        $I->wantToTest('Collection - serialize()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $serialized = serialize($data);

        $collection = new ReadCollection();

        $collection->unserialize($serialized);

        $I->assertEquals(
            $data,
            $collection->toArray()
        );
    }
}