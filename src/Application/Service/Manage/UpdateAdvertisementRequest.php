<?php

namespace App\Application\Service\Manage;

use App\Domain\Model\AppRequest;

/**
 * @author NewRehtse
 */
class UpdateAdvertisementRequest implements AppRequest
{
    /** @var string */
    private $id;

    /** @var int */
    private $status;

    /** @var array */
    private $components;

    /**
     * CreateAdvertisementRequest constructor.
     *
     * @param string $id
     * @param array  $components
     * @param int    $status
     */
    public function __construct(string $id, array $components, int $status)
    {
        $this->id = $id;
        $this->status = $status;
        $this->components = $components;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
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
