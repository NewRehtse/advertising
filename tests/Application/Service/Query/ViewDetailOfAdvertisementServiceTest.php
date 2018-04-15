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

namespace Tests\App\Application\Service\Query;


use App\Application\Service\AdvertisingFactory;
use App\Application\Service\Query\ViewDetailOfAdvertisementRequest;
use App\Application\Service\Query\ViewDetailOfAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Query\ViewDetailOfAdvertisementService
 */
class ViewDetailOfAdvertisementServiceTest extends TestCase
{
    /**
     * @tests
     */
    public function shouldListAdvertisements(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true);
        $viewListOfAdvertisementService = new ViewDetailOfAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewDetailOfAdvertisementRequest('id');
        $advs = $viewListOfAdvertisementService->execute($request);

        $this->assertInstanceOf(Advertisement::class, $advs);
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
        $viewListOfAdvertisementService = new ViewDetailOfAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $viewListOfAdvertisementService->execute($request);

    }

    /**
     * @param bool $getById
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($getById = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($getById) {
            $mock->expects($this->once())
                ->method('getById')
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

