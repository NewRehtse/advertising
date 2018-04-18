<?php

namespace Tests\App\Application\Service;

use App\Application\Service\AdvertisingFactory;
use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Image;
use App\Domain\Model\Position;
use App\Domain\Model\Text;
use App\Domain\Model\Video;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Application\Service\AdvertisingFactory
 */
class AdvertisingFactoryTest extends TestCase
{
    /** @var AdvertisingFactory */
    private $factory;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->factory = new AdvertisingFactory();
    }

    /**
     * @test
     */
    public function shouldBuildValidAdvertisement()
    {
        /** @var AppId $id */
        $id = $this->getAppIdMock();

        $adv = $this->factory->build($id, [$this->getTextComponentMock(true)], 0);

        $this->assertInstanceOf(Advertisement::class, $adv);
    }

    /**
     * @test
     *
     * @dataProvider getAdvArrayData
     *
     * @param array $data
     */
    public function shouldBuildValidAdvertisementFromArray($data)
    {
        $adv = $this->factory->buildAdvertisementFromArray($data);

        $this->assertInstanceOf(Advertisement::class, $adv);
    }

    /**
     * @return array
     */
    public function getAdvArrayData(): array
    {
        return [
            'data' => [
                [
                    'id' => $this->getAppIdMock(),
                    'status' => Advertisement::ADV_STATUS_STOPPED,
                    'components' => [
                        [
                            'text' => 'text',
                            'name' => 'name',
                            'positionX' => 30,
                            'positionY' => 30,
                            'positionZ' => 30,
                            'width' => 30,
                            'height' => 30,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider getComponentArrayData
     *
     * @param array $data
     */
    public function shouldBuildValidComponentFromArray($data): void
    {
        $component = $this->factory->buildComponentFromArray($data);

        $this->assertInstanceOf($data['class'], $component);
    }

    /**
     * @return array
     */
    public function getComponentArrayData(): array
    {
        return [
            'text' => [
                [
                    'text' => 'text',
                    'name' => 'name',
                    'positionX' => 30,
                    'positionY' => 30,
                    'positionZ' => 30,
                    'width' => 30,
                    'height' => 30,
                    'class' => Text::class,
                ],
            ],
            'image' => [
                [
                    'weight' => 3,
                    'format' => 'jpg',
                    'url' => 'url',
                    'name' => 'name',
                    'positionX' => 30,
                    'positionY' => 30,
                    'positionZ' => 30,
                    'width' => 30,
                    'height' => 30,
                    'class' => Image::class,
                ],
            ],
            'video' => [
                [
                    'weight' => 3,
                    'format' => 'mp4',
                    'url' => 'url',
                    'name' => 'name',
                    'positionX' => 30,
                    'positionY' => 30,
                    'positionZ' => 30,
                    'width' => 30,
                    'height' => 30,
                    'class' => Video::class,
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function shouldBuildValidImage()
    {
        /** @var AppId $id */
        $id = $this->getAppIdMock();
        $text = $this->factory->buildImage($id, 'name', 'url');

        $this->assertInstanceOf(Image::class, $text);
    }

    /**
     * @test
     */
    public function shouldBuildValidAppId(): void
    {
        /** @var AppId $id */
        $id = $this->getAppIdMock();
        $text = $this->factory->buildVideo($id, 'name', 'url');

        $this->assertInstanceOf(Video::class, $text);
    }

    /**
     * @test
     */
    public function shouldBuildValidVideo(): void
    {
        /** @var AppId $id */
        $id = $this->getAppIdMock();
        $text = $this->factory->buildVideo($id, 'name', 'url');

        $this->assertInstanceOf(Video::class, $text);
    }

    /**
     * @test
     */
    public function shouldBuildValidText(): void
    {
        /** @var AppId $id */
        $id = $this->getAppIdMock();
        $text = $this->factory->buildText($id, 'name', 'text');

        $this->assertInstanceOf(Text::class, $text);
    }

    /**
     * @test
     */
    public function shouldBuildValidPosition(): void
    {
        $position = $this->factory->buildPosition(1, 2, 3);

        $this->assertInstanceOf(Position::class, $position);
    }

    /**
     * @return MockObject
     */
    private function getAppIdMock(): MockObject
    {
        return $this->createMock(AppId::class);
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
