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
use App\Application\Service\Manage\CreateAdvertisementRequest;
use App\Application\Service\Manage\CreateAdvertisementService;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
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
     * @param $data
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
     * @param bool $create
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($create = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($create) {
            $mock->expects($this->once())
                ->method('create')
                ->willReturn($this->getAdvertisementMock());
        }

        return $mock;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $producerMock = $this->getMockBuilder(Advertisement::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $producerMock;
    }
}

