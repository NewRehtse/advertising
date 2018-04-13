<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
abstract class Component implements ValidateInterface
{
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
     * @return AppId
     */
    public function id(): AppId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Position
     */
    public function position(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     *
     * @return $this
     */
    public function setPosition($position): self
    {
        $this->position = $position;

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
