<?php
/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */
declare(strict_types=1);

namespace Cardoe\DM\Orm\Transaction;

use Cardoe\DM\Mapper\Mapper;
use Cardoe\DM\Mapper\Record;

/**
 * Support for manual transaction control.
 */
class AutoCommit extends Transaction
{
    public function read(Mapper $mapper, string $method, array $params)
    {
        return $mapper->$method(...$params);
    }

    public function write(Mapper $mapper, string $method, Record $record): void
    {
        $this->connectionLocator->lockToWrite();
        $mapper->$method($record);
    }
}
