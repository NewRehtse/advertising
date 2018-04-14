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

use App\Domain\Model\Advertisement;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppId;
use App\Domain\Model\Exceptions\ElementNotFound;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementRepository extends ServiceEntityRepository implements AdvertisementRepositoryInterface
{
    /** @var AdvertisingFactoryInterface */
    private $factory;

    /**
     * @param AdvertisingFactoryInterface $factory
     */
    public function setFactory(AdvertisingFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * AdvertisementRepository constructor.
     *
     * @param RegistryInterface $registry
     * @param AdvertisingFactoryInterface $factory
     */
    public function __construct(RegistryInterface $registry, AdvertisingFactoryInterface $factory)
    {
        parent::__construct($registry, Advertisement::class);
        $this->factory = $factory;
    }

    /**
     * @param AppId $id
     *
     * @throws ElementNotFound
     *
     * @return Advertisement
     */
    public function getById(AppId $id): Advertisement
    {
        $result = $this->createQueryBuilder('q')
            ->where(['id' => $id])
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getOneOrNullResult();
        if (null === $result) {
            throw new ElementNotFound("Article doesn't exist.");
        }

        return $this->factory->buildAdvertisementFromArray($result);
    }

    /**
     * @param Advertisement $advertisement
     */
    public function create(Advertisement $advertisement): void
    {
        $this->_em->persist($advertisement);
        $this->_em->flush();
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return ArrayCollection|Advertisement[]
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
        $result = $q->getQuery()->getResult();
        var_dump($result[0]);die();
        $collection = new ArrayCollection();
        foreach ($result as $row) {
            $collection->set($row['id'], $this->factory->buildAdvertisementFromArray($row));
        }
        var_dump($collection);
        die();

        return $collection;
    }
}
