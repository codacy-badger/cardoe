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

namespace Phalcon\Test\Models;

use Phalcon\Mvc\Model;

class ModelWithStringPrimary extends Model
{
    /**
     * @var string
     */
    public $uuid;

    /**
     * @var int
     */
    public $int_field;

    public function initialize()
    {
        $this->setSource('table_with_uuid_primary');
    }
}
