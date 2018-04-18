<?php

namespace Tests\App\Domain\Model;

use App\Domain\Model\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Domain\Model\Position
 */
class PositionTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param int $x
     * @param int $y
     * @param int $z
     */
    public function shouldCreateValidPositionObject($x, $y, $z): void
    {
        $position = new Position($x, $y, $z);

        $this->assertInstanceOf(Position::class, $position);
        $this->assertEquals($x, $position->x());
        $this->assertEquals($y, $position->y());
        $this->assertEquals($z, $position->z());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'esquina' => [
                0, 0, 0,
            ],
            '3d' => [
                20, 10, 20,
            ],
        ];
    }
}
