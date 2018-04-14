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
use App\Domain\Model\AppRequest;
use App\Domain\Model\AppService;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ViewListOfAdvertisementService implements AppService
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
        //TODO tengo problemas con el namespace... symfony4.0 too new at this moment for me
        /**
        if ($request instanceof ViewListOfAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid');
        }
         */

        /** @var ViewListOfAdvertisementRequest $request */
        $limit = $request->limit();
        $offset = $request->offset();

        $count = 0;
        $total = 0;
        return $this->advertisementRepository->getList($limit, $offset);
    }
}

