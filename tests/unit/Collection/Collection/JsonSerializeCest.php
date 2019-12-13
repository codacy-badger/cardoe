<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Collection\Collection;

use Cardoe\Collection\Collection;
use Cardoe\Test\Fixtures\Helper\JsonFixture;
use UnitTester;

class JsonSerializeCest
{
    /**
     * Tests Cardoe\Collection\Collection :: jsonSerialize()
     *
     * @since  2018-11-13
     */
    public function collectionJsonSerialize(UnitTester $I)
    {
        $I->wantToTest('Collection\Collection - jsonSerialize()');

        $data = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];

        $collection = new Collection($data);

        $I->assertEquals(
            $data,
            $collection->jsonSerialize()
        );

        $data = [
            'one'    => 'two',
            'three'  => 'four',
            'five'   => 'six',
            'object' => new JsonFixture(),
        ];

        $expected = [
            'one'    => 'two',
            'three'  => 'four',
            'five'   => 'six',
            'object' => [
                'one' => 'two'
            ],
        ];

        $collection = new Collection($data);

        $I->assertEquals(
            $expected,
            $collection->jsonSerialize()
        );
    }
}
