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

namespace Phalcon\Test\Unit\Cache\Adapter\Libmemcached;

use UnitTester;

class GetDefaultSerializerCest
{
    /**
     * Unit Tests Phalcon\Cache\Adapter\Libmemcached :: getDefaultSerializer()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2019-05-25
     */
    public function cacheAdapterLibmemcachedGetDefaultSerializer(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - getDefaultSerializer()');

        $I->skipTest('Need implementation');
    }
}
