<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container\Builder;
use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class MutationsCest
{
    /**
     * Unit Tests Phalcon\Container :: mutations()
     *
     * @since  2020-01-01
     */
    public function containerMutations(UnitTester $I)
    {
        $I->wantToTest('Container - mutations()');

        $builder   = new Builder();
        $container = $builder->newInstance();
        $container->mutations()->set('mutationOne', ['one', 'two']);
        $I->assertInstanceOf(ValueObject::class, $container->mutations());
        $I->assertEquals(
            [
                'one',
                'two',
            ],
            $container->mutations()->get('mutationOne')
        );
    }
}