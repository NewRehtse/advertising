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

namespace App\Application\Service\Manage;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class DeleteAdvertisementService extends BaseAdvertisementService
{

    /**
     * @param AppRequest|null $request
     *
     * @throws \InvalidArgumentException
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof DeleteAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var UpdateAdvertisementRequest $request */
        $advertisement = $this->findOrFail($request->id());

        $this->advertisementRepository()->remove($advertisement);
    }
}

