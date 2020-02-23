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

namespace Phalcon\Filter\Sanitize;

/**
 * Phalcon\Filter\Sanitize\Alpha
 *
 * Sanitizes a value to an alpha value
 */
class Alpha
{
    /**
     * @var mixed input The text to sanitize
     *
     * @return string|string[]|null
     */
    public function __invoke($input)
    {
        return preg_replace("/[^A-Za-z]/", "", $input);
    }
}
