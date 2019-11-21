<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Msgpack;

use Cardoe\Storage\Serializer\Msgpack;
use Codeception\Example;
use stdClass;
use UnitTester;
use function msgpack_pack;

class SerializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Msgpack :: serialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-30
     */
    public function storageSerializerMsgpackSerialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Msgpack - serialize() - ' . $example[0]);

        $serializer = new Msgpack($example[1]);

        $expected = $example[2];

        $I->assertEquals(
            $expected,
            $serializer->serialize()
        );
    }

    private function getExamples(): array
    {
        return [
            [
                'null',
                null,
                null,
            ],
            [
                'true',
                true,
                true,
            ],
            [
                'false',
                false,
                false,
            ],
            [
                'integer',
                1234,
                1234,
            ],
            [
                'float',
                1.234,
                1.234,
            ],
            [
                'string',
                'Cardoe Framework',
                msgpack_pack('Cardoe Framework'),
            ],
            [
                'array',
                ['Cardoe Framework'],
                msgpack_pack(['Cardoe Framework']),
            ],
            [
                'object',
                new stdClass(),
                msgpack_pack(new stdClass()),
            ],
        ];
    }
}
