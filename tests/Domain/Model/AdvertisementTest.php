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
use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Media;
use App\Domain\Model\Text;
use PHPUnit\Framework\TestCase;
use \PHPUnit\Framework\MockObject\MockObject;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Domain\Model\Advertisement
 */
class AdvertisementTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateValidAdvertisingObject(): void
    {
        /** @var Media $validComponent */
        $validComponent = $this->getMediaComponentMock(true);
        /** @var Text $validComponent */
        $validTextComponent = $this->getTextComponentMock(true);

        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertisement($id, [$validComponent, $validTextComponent]);

        $this->assertInstanceOf(Advertisement::class, $adv);
        $this->assertEquals($id, $adv->id());
        $this->assertEquals(Advertisement::ADV_STATUS_PUBLISHED, $adv->status()); //initial status

        /** @var Component $newComponent */
        $newComponent = $this->getMediaComponentMockWithId(new AppId());
        $adv->addComponent($newComponent);

        $adv->removeComponent($newComponent);

        $adv->setStatus(Advertisement::ADV_STATUS_STOPPED);
        $this->assertEquals(Advertisement::ADV_STATUS_STOPPED, $adv->status());
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidComponentException
     */
    public function shouldNotAddNotValidComponent(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getMediaComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertisement($id, [$validComponent, $validComponent]);

        /** @var Component $newComponent */
        $newComponent = $this->getMediaComponentMockWithId(new AppId(), false);
        $adv->addComponent($newComponent);
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidComponentException
     */
    public function shouldNotAddNotValidComponentBecauseIsNotAComponent(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getMediaComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        new Advertisement($id, [$validComponent, 'other']);
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidComponentException
     */
    public function shouldNotCreateAdvertisingObjectBecauseNotEveryComponentIsValid(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getMediaComponentMock(true);
        $noValidComponent = $this->getMediaComponentMock(false);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $noValidComponent];

        new Advertisement($id, $components);
    }

    private function getMediaComponentMockWithId(AppId $id, $valid = true)
    {
        $component = $this->getMediaComponentMock($valid);

        $component->method('id')
            ->willReturn($id);

        return $component;
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidStatusException
     */
    public function shouldNotLetChangeWhenIsPublishing(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getMediaComponentMock(true);

        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        $adv = new Advertisement($id, $components, Advertisement::ADV_STATUS_PUBLISHING);

        $this->assertEquals(Advertisement::ADV_STATUS_PUBLISHING, $adv->status());

        $adv->setStatus(Advertisement::ADV_STATUS_STOPPED);
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidStatusException
     */
    public function shouldNotLetChangeWhenIsNotValidState(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getMediaComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        $adv = new Advertisement($id, $components);

        $adv->setStatus(89); //estado que no existe
    }

    /**
     * @param bool $valid
     *
     * @return MockObject
     */
    private function getMediaComponentMock($valid): MockObject
    {
        $component = $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();

        $component->expects($this->any())
            ->method('isValid')
            ->willReturn($valid);

        return $component;
    }

    /**
     * @param bool $valid
     *
     * @return MockObject
     */
    private function getTextComponentMock($valid): MockObject
    {
        $component = $this->getMockBuilder(Text::class)
            ->disableOriginalConstructor()
            ->getMock();

        $component->expects($this->any())
            ->method('isValid')
            ->willReturn($valid);

        return $component;
    }
}
