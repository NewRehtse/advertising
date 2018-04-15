<?php

namespace App\Domain\Model\Repositories;

use App\Domain\Model\AppId;
use App\Domain\Model\Component;
use App\Domain\Model\Exceptions\ElementNotFound;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface ComponentRepositoryInterface
{
    /**
     * @param AppId $id
     *
     * @throws ElementNotFound
     *
     * @return object
     */
    public function getById(AppId $id);

    /**
     * @param Component $component
     */
    public function remove(Component $component): void;

    /**
     * @param Component $advertisement
     */
    public function persist(Component $advertisement): void;

    /**
     * @param int $limit
     * @param int $offset
     *
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return ArrayCollection|Component[]
     */
    public function getList(int $limit = 0, int $offset = 0): ArrayCollection;
}
