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

use App\Domain\Model\Component;
use App\Domain\Model\Advertising;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Domain\Model\Advertising
 */
class AdvertisingTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateValidAdvertisingObject(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertising($id, [$validComponent, $validComponent]);

        $this->assertInstanceOf(Advertising::class, $adv);
        $this->assertEquals($id, $adv->id());
        $this->assertEquals(Advertising::ADV_STATE_PUBLISHED, $adv->state()); //initial state
        $this->assertNotEmpty($adv->components());
        $this->assertEquals($validComponent, $adv->components()[0]);
        $this->assertEquals($validComponent, $adv->components()[1]);

        /** @var Component $newComponent */
        $newComponent = $this->getComponentMockWithId(new AppId());
        $adv->addComponent($newComponent);
        $this->assertCount(3, $adv->components());

        $adv->removeComponent($newComponent);
        $this->assertCount(2, $adv->components());

        $adv->setState(Advertising::ADV_STATE_STOPPED);
        $this->assertEquals(Advertising::ADV_STATE_STOPPED, $adv->state());
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\InvalidComponentException
     */
    public function shouldNotAddNotValidComponent(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertising($id, [$validComponent, $validComponent]);

        /** @var Component $newComponent */
        $newComponent = $this->getComponentMockWithId(new AppId(), false);
        $adv->addComponent($newComponent);
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\InvalidComponentException
     */
    public function shouldNotCreateAdvertisingObjectBecauseNotEveryComponentIsValid(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getComponentMock(true);
        $noValidComponent = $this->getComponentMock(false);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $noValidComponent];

        new Advertising($id, $components);
    }

    private function getComponentMockWithId(AppId $id, $valid = true)
    {
        $component = $this->getComponentMock($valid);

        $component->method('id')
            ->willReturn($id);

        return $component;
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\InvalidStateException
     */
    public function shouldNotLetChangeWhenIsPublishing(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getComponentMock(true);

        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        $adv = new Advertising($id, $components, Advertising::ADV_STATE_PUBLISHING);

        $this->assertEquals(Advertising::ADV_STATE_PUBLISHING, $adv->state());

        $adv->setState(Advertising::ADV_STATE_STOPPED);
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\InvalidStateException
     */
    public function shouldNotLetChangeWhenIsNotValidState(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        $adv = new Advertising($id, $components);

        $adv->setState(89); //estado que no existe
    }

    /**
     * @param bool $valid
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getComponentMock($valid): \PHPUnit\Framework\MockObject\MockObject
    {
        $component = $this->getMockBuilder(Component::class)
            ->disableOriginalConstructor()
            ->getMock();

        $component->expects($this->any())
            ->method('isValid')
            ->willReturn($valid);

        return $component;
    }
}
