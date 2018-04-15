<?php

namespace App\Application\Service\Manage;

use App\Domain\Model\AppRequest;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class CreateAdvertisementRequest implements AppRequest
{
    /** @var int */
    private $status;

    /** @var array */
    private $components;

    /**
     * CreateAdvertisementRequest constructor.
     *
     * @param int   $status
     * @param array $components
     */
    public function __construct($status, array $components)
    {
        $this->status = $status;
        $this->components = $components;
    }

    /**
     * @return int
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function components(): array
    {
        return $this->components;
    }
}
