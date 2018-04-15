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
use App\Domain\Model\Component;
use App\Domain\Model\Image;
use App\Domain\Model\Text;
use App\Domain\Model\Video;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class UpdateAdvertisementService extends BaseAdvertisementService
{

    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof UpdateAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var UpdateAdvertisementRequest $request */
        $advertisement = $this->findOrFail($request->id());

        $advertisement->setStatus($request->status());

        $nuevos = [];
        foreach ($request->components() as $c) {
        {
            $finded = false;
            /** @var Component $i */
            foreach ($advertisement->components()->getIterator() as $i)
                if (isset($c['id']) && $c['id'] === $i->id()) {
                    $finded = true;
                    //Entonces existe y hay que modificarlo
                    $i->setHeight($c['height']);
                    $i->setWidth($c['width']);
                    $i->setPosition($this->factory()->buildPosition($c['positionX'], $c['positionY'], $c['positionZ']));

                    if ($i instanceof Video || $i instanceof Image) {
                        $i->setWeight($c['weight']);
                        $i->setFormat($c['format']);
                        $i->setUrl($c['url']);
                    }
                    if ($i instanceof Text) {
                        $i->setText($c['text']);
                    }
                }
            }

            if (false === $finded) {
                $nuevos[] = $c;
            }
        }

        foreach ($nuevos as $c) {
            $advertisement->addComponent($this->factory()->buildComponentFromArray($c));
        }

        $this->advertisementRepository()->persist($advertisement);

        return $advertisement;
    }
}

