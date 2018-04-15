<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
abstract class Component implements ValidateInterface
{
    /** @var Advertisement */
    private $advertisement;

    /** @var AppId */
    private $id;

    /** @var string */
    private $name;

    /** @var Position */
    private $position;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    /** @var int */
    private $positionX;

    /** @var int */
    private $positionY;

    /** @var int */
    private $positionZ;

    /**
     * Component constructor.
     *
     * @param AppId  $id
     * @param string $name
     */
    public function __construct(AppId $id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return Advertisement
     */
    public function advertisement(): Advertisement
    {
        return $this->advertisement;
    }

    /**
     * @param Advertisement $advertisement
     *
     * @return $this
     */
    public function setAdvertisement(Advertisement $advertisement): self
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return (string) $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Position|null
     */
    public function position(): ?Position
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function positionX(): int
    {
        return $this->position() ? $this->position()->x() : $this->positionX;
    }

    /**
     * @return int
     */
    public function positionY(): int
    {
        return $this->position() ? $this->position()->y() : $this->positionY;
    }

    /**
     * @return int
     */
    public function positionZ(): int
    {
        return $this->position() ? $this->position()->z() : $this->positionZ;
    }

    /**
     * @param Position $position
     *
     * @return $this
     */
    public function setPosition(Position $position): self
    {
        $this->position = $position;
        $this->positionX = $position->x();
        $this->positionY = $position->y();
        $this->positionZ = $position->z();

        return $this;
    }

    /**
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height): self
    {
        $this->height = $height;

        return $this;
    }
}
