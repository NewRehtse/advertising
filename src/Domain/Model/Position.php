<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Position
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var int */
    private $z;

    /**
     * Position constructor.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     */
    public function __construct($x, $y, $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * @return int
     */
    public function x(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function y(): int
    {
        return $this->y;
    }

    /**
     * @return int
     */
    public function z(): int
    {
        return $this->z;
    }
}
