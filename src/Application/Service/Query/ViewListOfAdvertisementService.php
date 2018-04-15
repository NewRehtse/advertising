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

namespace App\Application\Service\Query;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ViewListOfAdvertisementService extends BaseAdvertisementService
{
    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof ViewListOfAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var ViewListOfAdvertisementRequest $request */
        $limit = $request->limit();
        $offset = $request->offset();

        return $this->advertisementRepository()->getList($limit, $offset);
    }
}

