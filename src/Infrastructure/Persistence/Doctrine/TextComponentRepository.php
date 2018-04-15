<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Repositories\TextComponentRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class TextComponentRepository extends EntityRepository implements TextComponentRepositoryInterface
{
}
