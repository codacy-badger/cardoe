<?php

/**
 * This file is part of the Phalcon.
 *
 * (c) Phalcon Team <team@phalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Helper;

/**
 * Phalcon\Helper\number
 *
 * This class offers numeric functions for the framework
 */
class Number
{
    /**
     * Helper method to get an array element or a default
     */
    /**
     * @param int $value
     * @param int $from
     * @param int $to
     *
     * @return bool
     */
    final public static function between(int $value, int $from, int $to): bool
    {
        return $value >= $from && $value <= $to;
    }
}
