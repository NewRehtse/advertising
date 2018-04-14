<?php
/*
* This file is part of the Vocento Software.
*
* (c) Vocento S.A., <desarrollo.dts@vocento.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Tests\App\Domain\Model;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Component;
use App\Domain\Model\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Domain\Model\Component
 */
class ComponentTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateComponentObject($data): void
    {
        $component = $this->getComponentMock($data);

        $obj = new \ReflectionObject($component);

        $setHeightMethod = $obj->getMethod('setHeight');
        $setWidthMethod = $obj->getMethod('setWidth');
        $setPositionMethod = $obj->getMethod('setPosition');

        $heightMethod = $obj->getMethod('height');
        $widthMethod = $obj->getMethod('width');
        $positionMethod = $obj->getMethod('position');
        $idMethod = $obj->getMethod('id');
        $nameMethod = $obj->getMethod('name');

        $positionXMethod = $obj->getMethod('positionX');
        $positionYMethod = $obj->getMethod('positionY');
        $positionZMethod = $obj->getMethod('positionZ');

        $setHeightMethod->invokeArgs($component, [$data['height']]);
        $setWidthMethod->invokeArgs($component, [$data['width']]);
        $setPositionMethod->invokeArgs($component, [$data['position']]);

        $this->assertEquals($data['id'], $idMethod->invoke($component));
        $this->assertEquals($data['name'], $nameMethod->invoke($component));
        $this->assertEquals($data['height'], $heightMethod->invoke($component));
        $this->assertEquals($data['width'], $widthMethod->invoke($component));
        $this->assertEquals($data['position'], $positionMethod->invoke($component));

        $this->assertEquals($data['position']->x(), $positionXMethod->invoke($component));
        $this->assertEquals($data['position']->y(), $positionYMethod->invoke($component));
        $this->assertEquals($data['position']->z(), $positionZMethod->invoke($component));
    }

    private function getComponentMock($data)
    {
        $component = $this->getMockBuilder(Component::class)
            ->setConstructorArgs([$data['id'], $data['name']])
            ->getMockForAbstractClass();

        return $component;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'adv1',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->getPositionMock(),
                    'valid' => true,
                ],
            ],
            'name-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => '',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->getPositionMock(),
                    'valid' => false,
                ],
            ],
            'url-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'adv1',
                    'url' => '',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->getPositionMock(),
                    'valid' => false,
                ],
            ],
        ];
    }

    private function getPositionMock()
    {
        $position = $this->getMockBuilder(Position::class)
            ->setConstructorArgs([1, 2, 3])
            ->getMock();

        $position->method('x')
            ->willReturn(1);
        $position->method('y')
            ->willReturn(2);
        $position->method('z')
            ->willReturn(3);

        return $position;
    }
}
