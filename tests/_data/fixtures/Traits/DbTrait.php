<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Fixtures\Traits;

use Phalcon\Db\Column;

use function array_shift;

trait DbTrait
{
    /**
     * Return the array of columns
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-02-01
     */
    protected function getColumnsArray(): array
    {
        return [
            0  => [
                'columnName'    => 'field_primary',
                'type'          => Column::TYPE_INTEGER,
                'isNumeric'     => true,
                'size'          => 11,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => true,
                'autoIncrement' => true,
                'primary'       => true,
                'first'         => true,
                'after'         => null,
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 0,
                'typeReference' => Column::TYPE_INTEGER,
            ],
            1  => [
                'columnName'    => 'field_blob',
                'type'          => Column::TYPE_BLOB,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_primary',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 1,
                'typeReference' => Column::TYPE_BLOB,
            ],
            2  => [
                'columnName'    => 'field_bit',
                'type'          => Column::TYPE_BIT,
                'isNumeric'     => false,
                'size'          => 1,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_blob',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 2,
                'typeReference' => Column::TYPE_BIT,
            ],
            3  => [
                'columnName'    => 'field_bit_default',
                'type'          => Column::TYPE_BIT,
                'isNumeric'     => false,
                'size'          => 1,
                'default'       => "b'1'",
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_bit',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 3,
                'typeReference' => Column::TYPE_BIT,
            ],
            4  => [
                'columnName'    => 'field_bigint',
                'type'          => Column::TYPE_BIGINTEGER,
                'isNumeric'     => true,
                'size'          => 20,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_bit_default',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 4,
                'typeReference' => Column::TYPE_BIGINTEGER,
            ],
            5  => [
                'columnName'    => 'field_bigint_default',
                'type'          => Column::TYPE_BIGINTEGER,
                'isNumeric'     => true,
                'size'          => 20,
                'scale'         => 0,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_bigint',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 5,
                'typeReference' => Column::TYPE_BIGINTEGER,
            ],
            6  => [
                'columnName'    => 'field_boolean',
                'type'          => Column::TYPE_TINYINTEGER,
                'isNumeric'     => true,
                'size'          => 1,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_bigint_default',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 6,
                'typeReference' => Column::TYPE_TINYINTEGER,
            ],
            7  => [
                'columnName'    => 'field_boolean_default',
                'type'          => Column::TYPE_TINYINTEGER,
                'isNumeric'     => true,
                'size'          => 1,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_boolean',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 7,
                'typeReference' => Column::TYPE_TINYINTEGER,
            ],
            8  => [
                'columnName'    => 'field_char',
                'type'          => Column::TYPE_CHAR,
                'isNumeric'     => false,
                'size'          => 10,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_boolean_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 8,
                'typeReference' => Column::TYPE_CHAR,
            ],
            9  => [
                'columnName'    => 'field_char_default',
                'type'          => Column::TYPE_CHAR,
                'isNumeric'     => false,
                'size'          => 10,
                'default'       => 'ABC',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_char',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 9,
                'typeReference' => Column::TYPE_CHAR,
            ],
            10 => [
                'columnName'    => 'field_decimal',
                'type'          => Column::TYPE_DECIMAL,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 4,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_char_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'a',
                'typeReference' => Column::TYPE_DECIMAL,
            ],
            11 => [
                'columnName'    => 'field_decimal_default',
                'type'          => Column::TYPE_DECIMAL,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 4,
                'default'       => '14.5678',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_decimal',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'b',
                'typeReference' => Column::TYPE_DECIMAL,
            ],
            12 => [
                'columnName'    => 'field_enum',
                'type'          => Column::TYPE_ENUM,
                'isNumeric'     => false,
                'size'          => "'xs','s','m','l','xl','internal'",
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_decimal_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'c',
                'typeReference' => Column::TYPE_ENUM,
            ],
            13 => [
                'columnName'    => 'field_integer',
                'type'          => Column::TYPE_INTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_enum',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 'd',
                'typeReference' => Column::TYPE_INTEGER,
            ],
            14 => [
                'columnName'    => 'field_integer_default',
                'type'          => Column::TYPE_INTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_integer',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 'e',
                'typeReference' => Column::TYPE_INTEGER,
            ],
            15 => [
                'columnName'    => 'field_json',
                'type'          => Column::TYPE_JSON,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_integer_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'f',
                'typeReference' => Column::TYPE_JSON,
            ],
            16 => [
                'columnName'    => 'field_float',
                'type'          => Column::TYPE_FLOAT,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 4,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_json',
                'bindType'      => Column::BIND_PARAM_DECIMAL,
                'typeValues'    => 'g',
                'typeReference' => Column::TYPE_FLOAT,
            ],
            17 => [
                'columnName'    => 'field_float_default',
                'type'          => Column::TYPE_FLOAT,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 4,
                'default'       => '14.5678',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_float',
                'bindType'      => Column::BIND_PARAM_DECIMAL,
                'typeValues'    => 'h',
                'typeReference' => Column::TYPE_FLOAT,
            ],
            18 => [
                'columnName'    => 'field_date',
                'type'          => Column::TYPE_DATE,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_float_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'i',
                'typeReference' => Column::TYPE_DATE,
            ],
            19 => [
                'columnName'    => 'field_date_default',
                'type'          => Column::TYPE_DATE,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => '2018-10-01',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_date',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'j',
                'typeReference' => Column::TYPE_DATE,
            ],
            20 => [
                'columnName'    => 'field_datetime',
                'type'          => Column::TYPE_DATETIME,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_date_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 10,
                'typeReference' => Column::TYPE_DATETIME,
            ],
            21 => [
                'columnName'    => 'field_datetime_default',
                'type'          => Column::TYPE_DATETIME,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => '2018-10-01 12:34:56',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_datetime',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 11,
                'typeReference' => Column::TYPE_DATETIME,
            ],
            22 => [
                'columnName'    => 'field_time',
                'type'          => Column::TYPE_TIME,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_datetime_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 12,
                'typeReference' => Column::TYPE_TIME,
            ],
            23 => [
                'columnName'    => 'field_time_default',
                'type'          => Column::TYPE_TIME,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => '12:34:56',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_time',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 13,
                'typeReference' => Column::TYPE_TIME,
            ],
            24 => [
                'columnName'    => 'field_timestamp',
                'type'          => Column::TYPE_TIMESTAMP,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_time_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 14,
                'typeReference' => Column::TYPE_TIMESTAMP,
            ],
            25 => [
                'columnName'    => 'field_timestamp_default',
                'type'          => Column::TYPE_TIMESTAMP,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => '2018-10-01 12:34:56',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_timestamp',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 15,
                'typeReference' => Column::TYPE_TIMESTAMP,
            ],
            26 => [
                'columnName'    => 'field_mediumint',
                'type'          => Column::TYPE_MEDIUMINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_timestamp_default',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 16,
                'typeReference' => Column::TYPE_MEDIUMINTEGER,
            ],
            27 => [
                'columnName'    => 'field_mediumint_default',
                'type'          => Column::TYPE_MEDIUMINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_mediumint',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 17,
                'typeReference' => Column::TYPE_MEDIUMINTEGER,
            ],
            28 => [
                'columnName'    => 'field_smallint',
                'type'          => Column::TYPE_SMALLINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_mediumint_default',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 18,
                'typeReference' => Column::TYPE_SMALLINTEGER,
            ],
            29 => [
                'columnName'    => 'field_smallint_default',
                'type'          => Column::TYPE_SMALLINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_smallint',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 19,
                'typeReference' => Column::TYPE_SMALLINTEGER,
            ],
            30 => [
                'columnName'    => 'field_tinyint',
                'type'          => Column::TYPE_TINYINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_smallint_default',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 'aa',
                'typeReference' => Column::TYPE_TINYINTEGER,
            ],
            31 => [
                'columnName'    => 'field_tinyint_default',
                'type'          => Column::TYPE_TINYINTEGER,
                'isNumeric'     => true,
                'size'          => 10,
                'scale'         => 0,
                'default'       => 1,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_tinyint',
                'bindType'      => Column::BIND_PARAM_INT,
                'typeValues'    => 'bb',
                'typeReference' => Column::TYPE_TINYINTEGER,
            ],
            32 => [
                'columnName'    => 'field_longtext',
                'type'          => Column::TYPE_LONGTEXT,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_tinyint_default',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'cc',
                'typeReference' => Column::TYPE_LONGTEXT,
            ],
            33 => [
                'columnName'    => 'field_mediumtext',
                'type'          => Column::TYPE_MEDIUMTEXT,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_longtext',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'dd',
                'typeReference' => Column::TYPE_MEDIUMTEXT,
            ],
            34 => [
                'columnName'    => 'field_tinytext',
                'type'          => Column::TYPE_TINYTEXT,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_mediumtext',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'ee',
                'typeReference' => Column::TYPE_TINYTEXT,
            ],
            35 => [
                'columnName'    => 'field_text',
                'type'          => Column::TYPE_TEXT,
                'isNumeric'     => false,
                'size'          => 0,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_tinytext',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'ff',
                'typeReference' => Column::TYPE_TEXT,
            ],
            36 => [
                'columnName'    => 'field_varchar',
                'type'          => Column::TYPE_VARCHAR,
                'isNumeric'     => false,
                'size'          => 10,
                'default'       => null,
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_text',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'gg',
                'typeReference' => Column::TYPE_VARCHAR,
            ],
            37 => [
                'columnName'    => 'field_varchar_default',
                'type'          => Column::TYPE_VARCHAR,
                'isNumeric'     => false,
                'size'          => 10,
                'default'       => 'D',
                'unsigned'      => false,
                'notNull'       => false,
                'autoIncrement' => false,
                'primary'       => false,
                'first'         => false,
                'after'         => 'field_varchar',
                'bindType'      => Column::BIND_PARAM_STR,
                'typeValues'    => 'hh',
                'typeReference' => Column::TYPE_VARCHAR,
            ],
        ];
    }

    /**
     * Return the array of expected columns
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-02-01
     */
    protected function getColumnsObjects(): array
    {
        $result = [];

        $columns = $this->getColumnsArray();

        foreach ($columns as $index => $array) {
            $name           = array_shift($array);
            $result[$index] = new Column($name, $array);
        }

        return $result;
    }
}
