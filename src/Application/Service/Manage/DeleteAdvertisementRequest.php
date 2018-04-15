<?php

namespace App\Application\Service\Manage;

use App\Domain\Model\AppRequest;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class DeleteAdvertisementRequest implements AppRequest
{
    /** @var string */
    private $id;

    /**
     * DeleteAdvertisementRequest constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
