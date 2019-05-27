<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use UnitTester;

class ValidateAnyCest
{
    /**
     * Tests Cardoe\Helper\Arr :: validateAny()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-07
     */
    public function helperArrValidateAny(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - validateAny()');
        $collection = [1, 2, 3, 4, 5];
        $actual     = Arr::validateAny(
            $collection,
            function ($element) {
                return $element < 2;
            }
        );
        $I->assertTrue($actual);
    }
}
