<?php

namespace App\Domain\Model;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AppId
{
    /** @var string */
    private $id;

    /**
     * Domain constructor.
     *
     * @param string|null $id
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __construct($id = null)
    {
        $this->setId($id ?? Uuid::uuid4()->toString());
    }

    /**
     * @param string $id
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return $this
     */
    private function setId($id): self
    {
        Assertion::notBlank($id, 'App id can not be blank');

        $this->id = $id;

        return $this;
    }

    /**
     * @param AppId $id
     *
     * @return bool
     */
    public function equals(self $id): bool
    {
        return $id->id() === $this->id();
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
