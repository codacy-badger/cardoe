<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Uri;

use Phalcon\Http\Message\Uri;
use Codeception\Example;
use InvalidArgumentException;
use UnitTester;

use function sprintf;

class WithPortCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: withPort()
     *
     * @dataProvider getExamples
     *
     * @since        2019-02-09
     */
    public function httpMessageUriWithPort(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Uri - withPort() - ' . $example[0]);

        $query = 'https://cardoe:secret@dev.cardoe.ld:%s/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, ':4300')
        );

        $newInstance = $uri->withPort($example[1]);

        $I->assertNotEquals(
            $uri,
            $newInstance
        );

        $I->assertEquals(
            $example[2],
            $newInstance->getPort()
        );

        $I->assertEquals(
            sprintf($query, $example[3]),
            (string) $newInstance
        );
    }

    /**
     * Tests Phalcon\Http\Message\Uri :: withPort() - exception no string
     *
     * @dataProvider getExceptions
     *
     * @since        2019-02-07
     */
    public function httpUriWithPortException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withPort() - ' . $example[0]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Method expects ' . $example[2]
            ),
            function () use ($example) {
                $query = 'https://cardoe:secret@dev.cardoe.ld%s/action?param=value#frag';

                $uri = new Uri(
                    sprintf($query, ':4300')
                );

                $newInstance = $uri->withPort($example[1]);
            }
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            ['null', null, null, ''],
            ['int', 8080, 8080, ':8080'],
            ['string-int', '8080', 8080, ':8080'],
            ['http', 80, null, ''],
            ['https', 443, null, ''],
        ];
    }

    /**
     * @return array
     */
    private function getExceptions(): array
    {
        return [
            ['port less than 1', -2, 'valid port (1-65535)'],
            ['port more than max', 70000, 'valid port (1-65535)'],
        ];
    }
}
