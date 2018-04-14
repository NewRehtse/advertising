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

use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\Component;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;
use App\Domain\Model\AppRequest;
use App\Domain\Model\AppService;
use App\Domain\Model\Repositories\ComponentRepositoryInterface;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class CreateAdvertisementService implements AppService
{
    /** @var AdvertisementRepositoryInterface  */
    private $advertisementRepository;

    /** @var AdvertisingFactoryInterface  */
    private $factory;

    /**
     * CreateAdvertisementService constructor.
     *
     * @param AdvertisementRepositoryInterface $advertisementRepository
     * @param AdvertisingFactoryInterface $factory
     */
    public function __construct(
        AdvertisementRepositoryInterface $advertisementRepository,
        AdvertisingFactoryInterface $factory
    ) {
        $this->factory = $factory;
        $this->advertisementRepository = $advertisementRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        $id = $this->factory->buildAppId();
        $components = [];
        /** @var CreateAdvertisementRequest $request */
        foreach($request->components() as $component) {
            /** @var Component $c */
            $c = $this->factory->buildComponentFromArray($component);
            if (isset($c)) {
                $components[] = $c;
            }
        }

        $advertisement = $this->factory->build($id, $components, $request->status());

        $this->advertisementRepository->create($advertisement);

        return $advertisement;
    }
}

