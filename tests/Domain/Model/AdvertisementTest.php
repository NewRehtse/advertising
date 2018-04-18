<?php

namespace Tests\App\Domain\Model;

use App\Domain\Model\Component;
use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Image;
use App\Domain\Model\Text;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author NewRehtse
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
        /** @var Image $validComponent */
        $validComponent = $this->getImageComponentMock(true);
        /** @var Text $validComponent */
        $validTextComponent = $this->getTextComponentMock(true);

        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertisement($id, [$validComponent, $validTextComponent]);

        $this->assertInstanceOf(Advertisement::class, $adv);
        $this->assertEquals($id, $adv->id());
        $this->assertEquals(Advertisement::ADV_STATUS_PUBLISHED, $adv->status()); //initial status

        /** @var Component $newComponent */
        $newComponent = $this->getImageComponentMockWithId(new AppId());
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
        $validComponent = $this->getImageComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        $adv = new Advertisement($id, [$validComponent, $validComponent]);

        /** @var Component $newComponent */
        $newComponent = $this->getImageComponentMockWithId(new AppId(), false);
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
        $validComponent = $this->getImageComponentMock(true);
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
        $validComponent = $this->getImageComponentMock(true);
        $noValidComponent = $this->getImageComponentMock(false);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $noValidComponent];

        new Advertisement($id, $components);
    }

    private function getImageComponentMockWithId(AppId $id, $valid = true)
    {
        $component = $this->getImageComponentMock($valid);

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
        $validComponent = $this->getImageComponentMock(true);

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
        $validComponent = $this->getImageComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        $adv = new Advertisement($id, $components);

        $adv->setStatus(89); //estado que no existe
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\InvalidStatusException
     */
    public function shouldNotLetCreateAdvertisementWithInvalidStatus(): void
    {
        /** @var Component $validComponent */
        $validComponent = $this->getImageComponentMock(true);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);

        /** @var Component[] $components */
        $components = [$validComponent, $validComponent];

        new Advertisement($id, $components, 42);
    }

    /**
     * @param bool $valid
     *
     * @return MockObject
     */
    private function getImageComponentMock($valid): MockObject
    {
        $component = $this->getMockBuilder(Image::class)
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
