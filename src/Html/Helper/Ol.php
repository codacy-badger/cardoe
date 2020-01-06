<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html\Helper;

/**
 * Class Ol
 */
class Ol extends AbstractList
{
    /**
     * @return string
     */
    protected function getTag(): string
    {
        return 'ol';
    }
}
