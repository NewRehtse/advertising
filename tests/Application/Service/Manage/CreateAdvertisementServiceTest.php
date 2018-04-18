<?php

namespace Tests\App\Application\Service\Manage;

use App\Application\Service\AdvertisingFactory;
use App\Application\Service\Manage\CreateAdvertisementRequest;
use App\Application\Service\Manage\CreateAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Application\Service\Manage\CreateAdvertisementService
 */
class CreateAdvertisementServiceTest extends TestCase
{
    /**
     * @tests
     *
     * @dataProvider getCreateAdvertisementData
     *
     * @param array $data
     */
    public function shouldCreateAdvertisement($data): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock();
        $createAdvertisementService = new CreateAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new CreateAdvertisementRequest($data['status'], $data['components']);
        $adv = $createAdvertisementService->execute($request);

        $this->assertInstanceOf(Advertisement::class, $adv);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function shouldGaveExceptionWHenBadRequest(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(false);
        $createAdvertisementService = new CreateAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $createAdvertisementService->execute($request);
    }

    /**
     * @return array
     */
    public function getCreateAdvertisementData(): array
    {
        return [
            [
                'uno' => [
                    'status' => 10,
                    'components' => [
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
    private function getAdvertisementRepositoryMock($persist = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($persist) {
            $mock->expects($this->once())
                ->method('persist')
                ->willReturn($this->getAdvertisementMock());
        }

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

        return $advertisementMock;
    }
}
