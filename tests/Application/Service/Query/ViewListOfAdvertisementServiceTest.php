<?php

namespace Tests\App\Application\Service\Query;

use App\Application\Service\AdvertisingFactory;
use App\Application\Service\Query\ViewDetailOfAdvertisementRequest;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Application\Service\Query\ViewListOfAdvertisementService;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Query\ViewListOfAdvertisementService
 */
class ViewListOfAdvertisementServiceTest extends TestCase
{
    /**
     * @tests
     */
    public function shouldListAdvertisements(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true);
        $viewListOfAdvertisementService = new ViewListOfAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $advs = $viewListOfAdvertisementService->execute($request);

        $this->assertInstanceOf(ArrayCollection::class, $advs);
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
        $viewListOfAdvertisementService = new ViewListOfAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewDetailOfAdvertisementRequest('id');
        $viewListOfAdvertisementService->execute($request);
    }

    /**
     * @param bool $getList
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($getList = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($getList) {
            $mock->expects($this->once())
                ->method('getList')
                ->willReturn($this->getArrayCollectionMock());
        }

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getArrayCollectionMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $advertisementMock = $this->getMockBuilder(ArrayCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $advertisementMock;
    }
}
