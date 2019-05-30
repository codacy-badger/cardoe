<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Request;
use Codeception\Example;
use UnitTester;

class WithHeaderCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withHeader()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithHeader(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withHeader()');

        $data = [
            'Accept' => ['text/html'],
        ];

        $request = new Request('GET', null, 'php://memory', $data);

        $newInstance = $request->withHeader(
            'Cache-Control',
            [
                'max-age=0',
            ]
        );

        $I->assertNotEquals($request, $newInstance);



        $expected = [
            'Accept' => ['text/html'],
        ];

        $I->assertEquals(
            $expected,
            $request->getHeaders()
        );



        $expected = [
            'Accept'        => ['text/html'],
            'Cache-Control' => ['max-age=0'],
        ];

        $I->assertEquals(
            $expected,
            $newInstance->getHeaders()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: withHeader() - exception
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithHeaderException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withHeader() value');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid header name Cache Control'
            ),
            function () {
                $request = new Request();

                $newInstance = $request->withHeader(
                    'Cache Control',
                    [
                        'max-age=0',
                    ]
                );
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: withHeader() - exception value
     *
     * @dataProvider getExamples
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithHeaderExceptionValue(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Request - withHeader() - exception value ' . $example[0]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid header value'
            ),
            function () use ($example) {
                $request = new Request();

                $newInstance = $request->withHeader(
                    'Cache-Control',
                    [
                        $example[1],
                    ]
                );
            }
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            ['not numeric or string', true],
            ['invalid\r\n', "some \r\n"],
            ['invalid\r', "some \r"],
            ['invalid\n', "some \n"],
        ];
    }
}