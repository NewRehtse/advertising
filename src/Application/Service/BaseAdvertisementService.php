<?php

namespace App\Application\Service;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppService;
use App\Domain\Model\Exceptions\ElementNotFound;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
abstract class BaseAdvertisementService implements AppService
{
    /** @var AdvertisementRepositoryInterface */
    private $advertisementRepository;

    /** @var AdvertisingFactoryInterface */
    private $factory;

    /**
     * CreateAdvertisementService constructor.
     *
     * @param AdvertisementRepositoryInterface $advertisementRepository
     * @param AdvertisingFactoryInterface      $factory
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
     * @return Advertisement
     */
    protected function findOrFail(string $id): Advertisement
    {
        $adv = $this->advertisementRepository()->getById($this->factory()->buildAppId($id));
        if (!$adv) {
            throw new ElementNotFound('Advertisement not found');
        }

        return $adv;
    }
}
