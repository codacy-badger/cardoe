<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Query
 * @license https://github.com/atlasphp/Atlas.Qyert/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Query;

use Phalcon\DM\Pdo\Connection;

use function array_keys;
use function array_merge;
use function array_shift;
use function call_user_func_array;
use function end;
use function func_get_args;
use function get_class_methods;
use function implode;
use function is_array;
use function is_numeric;
use function is_string;
use function key;
use function ltrim;
use function strtoupper;
use function substr;
use function trim;

/**
 * Class AbstractConditions
 */
abstract class AbstractConditions extends AbstractQuery
{
    /**
     * Sets the `LIMIT` clause
     *
     * @param int $limit
     *
     * @return AbstractConditions
     */
    public function limit(int $limit): AbstractConditions
    {
        $this->store["LIMIT"] = $limit;

        return $this;
    }

    /**
     * Sets the `OFFSET` clause
     *
     * @param int $offset
     *
     * @return AbstractConditions
     */
    public function offset(int $offset): AbstractConditions
    {
        $this->store["OFFSET"] = $offset;

        return $this;
    }

    /**
     * Sets a `AND` for a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return AbstractConditions
     */
    public function andWhere(string $condition, $value = null, int $type = -1): AbstractConditions
    {
        $this->where($condition, $value, $type);

        return $this;
    }

    /**
     * Concatenates to the most recent `WHERE` clause
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return AbstractConditions
     */
    public function catWhere(string $condition, $value = null, int $type = -1): AbstractConditions
    {
        $this->catCondition("WHERE", $condition, $value, $type);

        return $this;
    }

    /**
     * Sets the `ORDER BY`
     *
     * @param array|string $orderBy
     *
     * @return AbstractConditions
     */
    public function orderBy($orderBy): AbstractConditions
    {
        $this->processValue("ORDER", $orderBy);

        return $this;
    }

    /**
     * Sets a `OR` for a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return AbstractConditions
     */
    public function orWhere(string $condition, $value = null, int $type = -1): AbstractConditions
    {
        $this->appendCondition("WHERE", "OR ", $condition, $value, $type);

        return $this;
    }

    /**
     * Sets a `WHERE` condition
     *
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     *
     * @return AbstractConditions
     */
    public function where(string $condition, $value = null, int $type = -1): AbstractConditions
    {
        $this->appendCondition("WHERE", "AND ", $condition, $value, $type);

        return $this;
    }

    /**
     * @param array $columnsValues
     *
     * @return AbstractConditions
     */
    public function whereEquals(array $columnsValues): AbstractConditions
    {
        foreach ($columnsValues as $key => $val) {
            if (is_numeric($key)) {
                $this->where($val);
            } elseif ($val === null) {
                $this->where($key . " IS NULL");
            } elseif (is_array($val)) {
                $this->where($key . " IN ", $val);
            } else {
                $this->where($key . " = ", $val);
            }
        }

        return $this;
    }

    /**
     * Appends a conditional
     *
     * @param string     $store
     * @param string     $andor
     * @param string     $condition
     * @param mixed|null $value
     * @param int        $type
     */
    protected function appendCondition(
        string $store,
        string $andor,
        string $condition,
        $value = null,
        $type = -1
    ): void {
        if (!empty($value)) {
            $condition .= $this->bindInline($value, $type);
        }

        if (empty($this->store[$store])) {
            $andor = "";
        }

        $this->store[$store][] = $andor . $condition;
    }

    /**
     * Builds a `BY` list
     *
     * @param string $type
     *
     * @return string
     */
    protected function buildBy(string $type): string
    {
        if (empty($this->store[$type])) {
            return "";
        }

        return " " . $type . " BY"
            . $this->indent($this->store[$type], ",");
    }

    /**
     * Builds the conditional string
     *
     * @param string $type
     *
     * @return string
     */
    protected function buildCondition(string $type): string
    {
        if (empty($this->store[$type])) {
            return "";
        }

        return " " . $type
            . $this->indent($this->store[$type]);
    }

    /**
     * Builds the early `LIMIT` clause - MS SQLServer
     *
     * @return string
     */
    protected function buildLimitEarly(): string
    {
        $limit = "";
        if ("sqlsrv" === $this->connection->getDriverName()) {
            if ($this->store["LIMIT"] > 0 && 0 === $this->store["OFFSET"]) {
                $limit = " TOP " . $this->store["LIMIT"];
            }
        }

        return $limit;
    }

    /**
     * Builds the `LIMIT` clause
     *
     * @return string
     */
    protected function buildLimit(): string
    {
        $limit = "";
        if ("sqlsrv" === $this->connection->getDriverName()) {
            if ($this->store["LIMIT"] > 0 && $this->store["OFFSET"] > 0) {
                $limit = " OFFSET " . $this->store["OFFSET"] . " ROWS"
                    . " FETCH NEXT " . $this->store["LIMIT"] . " ROWS ONLY";
            }
        } else {
            if (0 !== $this->store["LIMIT"]) {
                $limit .= "LIMIT " . $this->store["LIMIT"];
            }

            if (0 !== $this->store["OFFSET"]) {
                $limit .= " OFFSET " . $this->store["OFFSET"];
            }

            if ("" !== $limit) {
                $limit = " " . ltrim($limit);
            }
        }

        return $limit;
    }

    /**
     * Concatenates a conditional
     *
     * @param string $store
     * @param string $condition
     * @param mixed  $value
     * @param int    $type
     */
    protected function catCondition(
        string $store,
        string $condition,
        $value = null,
        int $type = -1
    ): void {
        if (!empty($value)) {
            $condition .= $this->bindInline($value, $type);
        }

        if (empty($this->store[$store])) {
            $this->store[$store][] = "";
        }

        end($this->store[$store]);
        $key = key($this->store[$store]);

        $this->store[$store][$key] .= $condition;
    }

    /**
     * Processes a value (array or string) and merges it with the store
     *
     * @param string       $store
     * @param array|string $data
     */
    protected function processValue(string $store, $data): void
    {
        if (is_string($data)) {
            $data = [$data];
        }

        if (is_array($data)) {
            $this->store[$store] = array_merge(
                $this->store[$store],
                $data
            );
        }
    }
}