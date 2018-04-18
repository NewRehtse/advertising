<?php

namespace Tests\App\Application\Service\DataTransformer;

use App\Application\Service\AdvertisingFactory;
use App\Application\Service\DataTransformer\AdvertisementDataTransformer;
use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;
use Tests\App\MockedClasses\ComponentNotAdded;
use Tests\App\MockedClasses\PersistentCollection;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author NewRehtse
 *
 * @covers \App\Application\Service\DataTransformer\AdvertisementDataTransformer
 */
class AdvertisementDataTransformerTest extends TestCase
{
    /** @var AdvertisementDataTransformer */
    private $dataTransformer;

    /** @var AdvertisingFactory */
    private $factory;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->dataTransformer = new AdvertisementDataTransformer(PersistentCollection::class);
        $this->factory = new AdvertisingFactory();
    }

    /**
     * @test
     *
     * @dataProvider getAdvArrayData
     *
     * @param array $data
     */
    public function shouldReturnArrayWithCorrectStructure($data): void
    {
        $adv = $this->factory->buildAdvertisementFromArray($data);
        $this->dataTransformer->write($adv);

        $arr = $this->dataTransformer->read();

        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('status', $arr);
        $this->assertArrayHasKey('components', $arr);
    }

    /**
     * @test
     *
     * @dataProvider getAdvArrayDataWithComponentsNotOk
     *
     * @param array $data
     */
    public function shouldReturnArrayWithCorrectStructureButComponentsNoOk($data): void
    {
        $adv = $this->factory->buildAdvertisementFromArray($data);
        /** @var AppId $id */
        $id = $this->createMock(AppId::class);
        $adv->addComponent(new ComponentNotAdded($id, 'name'));
        $this->dataTransformer->write($adv);

        $arr = $this->dataTransformer->read();

        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('status', $arr);
        $this->assertArrayHasKey('components', $arr);
    }

    /**
     * @test
     *
     * @dataProvider getAdvArrayData
     *
     * @param array $data
     */
    public function shouldReturnArrayWithCorrectStructureFromDB($data): void
    {
        /** @var Advertisement $adv */
        $adv = $this->getAdvertisementMockForDataTransformer($data);
        $this->dataTransformer->write($adv);

        $arr = $this->dataTransformer->read();

        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('status', $arr);
        $this->assertArrayHasKey('components', $arr);
    }

    /**
     * @param array $data
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getAdvertisementMockForDataTransformer($data): MockObject
    {
        $adv = $this->getMockBuilder(Advertisement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adv->method('components')
            ->willReturn($this->getPersistentCollectionMock($data));
        $adv->method('id')
            ->willReturn($data['id']);
        $adv->method('status')
            ->willReturn($data['status']);

        return $adv;
    }

    /**
     * @param array $data
     *
     * @return PersistentCollection
     */
    private function getPersistentCollectionMock($data): PersistentCollection
    {
        $arrComponents = [];
        foreach ($data['components'] as $c) {
            $arrComponents[] = $this->factory->buildComponentFromArray($c);
        }

        $persistentCollection = new PersistentCollection();
        $persistentCollection->setIterator($arrComponents);

        return $persistentCollection;
    }

    /**
     * @return array
     */
    public function getAdvArrayData(): array
    {
        return [
            'data' => [
                [
                    'id' => $this->createMock(AppId::class),
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
                        ],
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
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getAdvArrayDataWithComponentsNotOk(): array
    {
        return [
            'data' => [
                [
                    'id' => $this->createMock(AppId::class),
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
}
