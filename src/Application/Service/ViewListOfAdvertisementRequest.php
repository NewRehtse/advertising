<?php
/*
* This file is part of the Vocento Software.
*
* (c) Vocento S.A., <desarrollo.dts@vocento.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace App\Application\Service;

use App\Domain\Model\AppRequest;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ViewListOfAdvertisementRequest implements AppRequest
{
    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /**
     * ViewListOfAdvertisementRequest constructor.
     *
     * @param int $limit
     * @param int $offset
     */
    public function __construct($limit = 10, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }
}

