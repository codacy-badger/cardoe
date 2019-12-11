<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo\Parser;

/**
 * Parsing/rebuilding functionality for the mysql driver.
 */
class MysqlParser extends AbstractParser
{
    /**
     * @var array
     */
    protected $split = [
        // single-quoted string
        "'(?:[^'\\\\]|\\\\'?)*'",
        // double-quoted string
        '"(?:[^"\\\\]|\\\\"?)*"',
        // backtick-quoted string
        '`(?:[^`\\\\]|\\\\`?)*`',
    ];

    /**
     * @var string
     */
    protected $skip = '/^(\'|\"|\`)/um';
}