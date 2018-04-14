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

use App\Domain\Model\AppId;
use App\Domain\Model\Component;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\Exceptions\ElementNotFound;
use App\Domain\Model\Repositories\ComponentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ComponentRepository extends ServiceEntityRepository implements ComponentRepositoryInterface
{
    /** @var AdvertisingFactoryInterface */
    private $factory;

    /**
     * AdvertisementRepository constructor.
     *
     * @param RegistryInterface $registry
     * @param AdvertisingFactoryInterface $factory
     */
    public function __construct(RegistryInterface $registry, AdvertisingFactoryInterface $factory)
    {
        parent::__construct($registry, Component::class);
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function getById(AppId $id): Component
    {
        $result = $this->createQueryBuilder('q')
            ->where(['id' => $id])
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getOneOrNullResult();
        if (null === $result) {
            throw new ElementNotFound("Article doesn't exist.");
        }

        return $this->factory->buildComponentFromArray($result);
    }

    /**
     * @inheritdoc
     */
    public function create(Component $advertisement): void
    {
        $this->_em->persist($advertisement);
        $this->_em->flush();
    }

    /**
     * @inheritdoc
     */
    public function getList(int $limit = 0, int $offset = 0): ArrayCollection
    {
        $q = $this->createQueryBuilder('q');
        if ($offset > 0) {
            $q->setFirstResult($offset);
        }
        if ($limit > 0) {
            $q->setMaxResults($limit);
        }
        $result = $q->getQuery()->getResult(Query::HYDRATE_ARRAY);
        $collection = new ArrayCollection();
        foreach ($result as $row) {
            $collection->set($row['id'], $this->factory->buildAdvertisementFromArray($row));
        }

        return $collection;
    }
}
