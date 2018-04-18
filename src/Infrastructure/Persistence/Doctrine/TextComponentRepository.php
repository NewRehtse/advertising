<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Repositories\TextComponentRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @author NewRehtse
 */
class TextComponentRepository extends EntityRepository implements TextComponentRepositoryInterface
{
}
