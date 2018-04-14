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

use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppService;
use App\Domain\Model\Exceptions\ElementNotFound;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
abstract class BaseAdvertisementService implements AppService
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
     * @return AdvertisingFactoryInterface
     */
    protected function factory(): AdvertisingFactoryInterface
    {
        return $this->factory;
    }

    /**
     * @return AdvertisementRepositoryInterface
     */
    protected function advertisementRepository(): AdvertisementRepositoryInterface
    {
        return $this->advertisementRepository;
    }

    /**
     * @param string $id
     *
     * @throws ElementNotFound
     *
     * @return \App\Domain\Model\Advertisement
     */
    protected function findOrFail(string $id)
    {
        $adv = $this->advertisementRepository()->getById($this->factory()->buildAppId($id));
        if (!$adv) {
            throw new ElementNotFound();
        }

        return $adv;
    }
}

