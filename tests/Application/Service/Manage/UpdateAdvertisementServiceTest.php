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

namespace Tests\App\Application\Service\Manage;


use App\Application\Service\AdvertisingFactory;
use App\Application\Service\Manage\UpdateAdvertisementRequest;
use App\Application\Service\Manage\UpdateAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use PHPUnit\Framework\TestCase;
use Tests\App\MockedClasses\PersistentCollection;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Manage\UpdateAdvertisementService
 */
class UpdateAdvertisementServiceTest extends TestCase
{
    /**
     * @tests
     *
     * @dataProvider getUpdateAdvertisementData
     *
     * @param $data
     */
    public function shouldUpdateAdvertisement($data): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true, true);
        $updateAdvertisementService = new UpdateAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new UpdateAdvertisementRequest($data['id'], $data['components'], $data['status']);
        $adv = $updateAdvertisementService->execute($request);

        $this->assertInstanceOf(Advertisement::class, $adv);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     */
    public function shouldGaveExceptionWHenBadRequest(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(false);
        $updateAdvertisementService = new UpdateAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $updateAdvertisementService->execute($request);
    }

    /**
     * @return array
     */
    public function getUpdateAdvertisementData(): array
    {
        return [
            [
                'uno' => [
                    'id' => 'id',
                    'status' => 10,
                    'components' => [
                        [
                            'id' => 'existente',
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
                            'format' => 'jpg',
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
     * @param bool $persist
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($persist = true, $find = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($persist) {
            $mock->expects($this->once())
                ->method('persist')
                ->willReturn($this->getAdvertisementMock());
        }

        $advertisement = $find ? $this->getAdvertisementMock() : null;

        $mock->expects($this->any())
            ->method('getById')
            ->willReturn($advertisement);

        return $mock;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $advertisementMock = $this->getMockBuilder(Advertisement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $advertisementMock->expects($this->any())
            ->method('components')
            ->willReturn($this->getPersistentCollectionMock());

        return $advertisementMock;
    }

    /**
     * @return PersistentCollection
     */
    private function getPersistentCollectionMock(): PersistentCollection
    {
        $arrComponent = [
                'id' => 'existente',
                'weight' => 3,
                'format' => 'jpg',
                'url' => 'url',
                'name' => 'name',
                'positionX' => 30,
                'positionY' => 30,
                'positionZ' => 30,
                'width' => 30,
                'height' => 30,
            ];
        $component1 = (new AdvertisingFactory())->buildComponentFromArray($arrComponent);
        $arrComponent = [
            'weight' => 3,
            'format' => 'jpg',
            'url' => 'url',
            'name' => 'name',
            'positionX' => 30,
            'positionY' => 30,
            'positionZ' => 30,
            'width' => 30,
            'height' => 30,
        ];
        $component2 = (new AdvertisingFactory())->buildComponentFromArray($arrComponent);
        $persistentCollection = new PersistentCollection();
        $persistentCollection->setIterator([$component1, $component2]);

        return $persistentCollection;
    }
}

