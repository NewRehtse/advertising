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
use App\Domain\Model\Component;
use App\Domain\Model\AppRequest;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class CreateAdvertisementService extends BaseAdvertisementService
{
    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        $id = $this->factory()->buildAppId();
        $components = [];
        /** @var CreateAdvertisementRequest $request */
        foreach($request->components() as $component) {
            /** @var Component $c */
            $c = $this->factory()->buildComponentFromArray($component);
            if (isset($c)) {
                $components[] = $c;
            }
        }

        $advertisement = $this->factory()->build($id, $components, $request->status());

        $this->advertisementRepository()->create($advertisement);

        return $advertisement;
    }
}

