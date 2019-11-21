<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Cache\CacheFactory;

use Cardoe\Cache;
use Cardoe\Cache\AdapterFactory;
use Cardoe\Cache\CacheFactory;
use Cardoe\Test\Fixtures\Traits\FactoryTrait;
use Psr\SimpleCache\CacheInterface;
use UnitTester;

class LoadCest
{
    use FactoryTrait;

    public function _before(UnitTester $I)
    {
        $this->init();
    }

    /**
     * Tests Cardoe\Cache\CacheFactory :: load()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-18
     */
    public function cacheCacheFactoryLoad(UnitTester $I)
    {
        $I->wantToTest('Cache\CacheFactory - load()');

        $options = $this->config->cache;
        $this->runTests($I, $options);
    }

    /**
     * Tests Cardoe\Cache\CacheFactory :: load()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-18
     */
    public function cacheCacheFactoryLoadArray(UnitTester $I)
    {
        $I->wantToTest('Cache\CacheFactory - load() - array');

        $options = $this->arrayConfig['cache'];
        $this->runTests($I, $options);
    }

    private function runTests(UnitTester $I, $options)
    {
        $cacheFactory = new CacheFactory(
            new AdapterFactory()
        );

        $adapter = $cacheFactory->load($options);

        $I->assertInstanceOf(
            Cache::class,
            $adapter
        );

        $I->assertInstanceOf(
            CacheInterface::class,
            $adapter
        );
    }
}
