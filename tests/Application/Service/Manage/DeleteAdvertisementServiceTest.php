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
use App\Application\Service\Manage\DeleteAdvertisementRequest;
use App\Application\Service\Manage\DeleteAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Manage\DeleteAdvertisementService
 */
class DeleteAdvertisementServiceTest extends TestCase
{
    /**
     * @tests
     *
     * @dataProvider getDeleteAdvertisementData

     * @param $data
     */
    public function shouldDeleteAdvertisement($data): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true, true);
        $deleteAdvertisementService = new DeleteAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new DeleteAdvertisementRequest($data['id']);
        $deleteAdvertisementService->execute($request);
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
        $deleteAdvertisementService = new DeleteAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $deleteAdvertisementService->execute($request);
    }

    /**
     * @return array
     */
    public function getDeleteAdvertisementData(): array
    {
        return [
            [
                'uno' => [
                    'id' => 'id',
                ],
            ],
        ];
    }

    /**
     * @param bool $remove
     * @param bool $find
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($remove = true, $find = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($remove) {
            $mock->expects($this->once())
                ->method('remove')
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

        return $advertisementMock;
    }

}

