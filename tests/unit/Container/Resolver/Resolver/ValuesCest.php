<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Resolver;

use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class ValuesCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: values()
     *
     * @since  2019-12-31
     */
    public function containerResolverResolverValues(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - values()');

        $resolver = new Resolver(new Reflector());
        $I->assertInstanceOf(ValueObject::class, $resolver->values());

        $resolver->values()->set('valueOne', 'two');
        $I->assertEquals(1, $resolver->values()->count());
    }
}