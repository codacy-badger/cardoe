<?php
/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
declare(strict_types=1);

namespace Cardoe\DM\Query\Quoter;

class SqliteQuoter extends Quoter
{
    public function quoteIdentifier(string $name): string
    {
        return '"' . $name . '"';
    }
}