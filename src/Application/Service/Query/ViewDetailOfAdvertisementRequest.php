<?php

namespace App\Application\Service\Query;

use App\Domain\Model\AppRequest;

/**
 * @author NewRehtse
 */
class ViewDetailOfAdvertisementRequest implements AppRequest
{
    /** @var string */
    private $id;

    /**
     * ViewDetailOfAdvertisementRequest constructor.
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
