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

namespace App\Domain\Model\Repositories;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Exceptions\ElementNotFound;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface AdvertisementRepositoryInterface
{
    /**
     * @param AppId $id
     *
     * @throws ElementNotFound
     */
    public function getById(AppId $id);

    /**
     * @param Advertisement $advertisement
     */
    public function persist(Advertisement $advertisement): void;

    /**
     * @param Advertisement $advertisement
     */
    public function remove(Advertisement $advertisement): void;

    /**
     * @param int $limit
     * @param int $offset
     *
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return ArrayCollection|Advertisement[]
     */
    public function getList(int $limit = 0, int $offset = 0): ArrayCollection;
}
