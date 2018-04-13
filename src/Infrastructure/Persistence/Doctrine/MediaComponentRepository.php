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

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Repositories\MediaComponentRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class MediaComponentRepository extends EntityRepository implements MediaComponentRepositoryInterface
{
}
