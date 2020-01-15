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

namespace Phalcon\Test\Unit\Http\Message\Uri;

use Codeception\Example;
use InvalidArgumentException;
use Phalcon\Http\Message\Uri;
use UnitTester;

class WithUserInfoCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: withUserInfo()
     *
     * @dataProvider getExamples
     *
     * @since        2019-02-09
     */
    public function httpMessageUriWithUserInfo(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Uri - withUserInfo()');

        $query = 'https://%s@dev.phalcon.ld:8080/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, 'zephir:module')
        );

        $newInstance = $uri->withUserInfo($example[1], $example[2]);

        $I->assertNotEquals($uri, $newInstance);

        $I->assertEquals(
            $example[3],
            $newInstance->getUserInfo()
        );

        $I->assertEquals(
            sprintf($query, $example[3]),
            (string) $newInstance
        );
    }

    /**
     * Tests Phalcon\Http\Message\Uri :: withUserInfo() - exception no string
     *
     * @dataProvider getExceptions
     *
     * @since        2019-02-07
     */
    public function httpUriWithUserInfoException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withUserInfo() - exception - ' . $example[1]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Method requires a string argument'
            ),
            function () use ($example) {
                $query = 'https://Phalcon:secret@dev.phalcon.ld:8080/action?param=value#frag';
                $uri   = new Uri($query);

                $instance = $uri->withUserInfo($example[2]);
            }
        );
    }

    private function getExamples(): array
    {
        return [
            ['valid', 'Phalcon', 'secret', 'Phalcon:secret'],
            ['user only', 'Phalcon', '', 'Phalcon'],
            ['email', 'Phalcon@secret', 'secret@Phalcon', 'Phalcon%40secret:secret%40Phalcon'],
            ['email', 'Phalcon:secret', 'secret:Phalcon', 'Phalcon%3Asecret:secret%3APhalcon'],
            ['percent', 'Phalcon%secret', 'secret%Phalcon', 'Phalcon%25secret:secret%25Phalcon'],
        ];
    }

    private function getExceptions(): array
    {
        return [
            ['NULL', 'null', null],
            ['boolean', 'true', true],
            ['boolean', 'false', false],
            ['integer', 'number', 1234],
            ['array', 'array', ['/action']],
            ['stdClass', 'object', (object) ['/action']],
        ];
    }
}
