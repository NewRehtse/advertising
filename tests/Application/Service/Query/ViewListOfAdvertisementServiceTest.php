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
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Application\Service\Query\ViewListOfAdvertisementService;
use App\Domain\Model\Advertisement;
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
    public function shouldListAdvertisements()
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true);
        $createAdvertisementService = new ViewListOfAdvertisementService(
            $advRepo,
            new AdvertisingFactory()
        );

        $request = new ViewListOfAdvertisementRequest();
        $advs = $createAdvertisementService->execute($request);

        $this->assertInstanceOf(ArrayCollection::class, $advs);
    }

    /**
     * @param bool $getList
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($getList = true)
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
    private function getArrayCollectionMock()
    {
        $producerMock = $this->getMockBuilder(ArrayCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $producerMock;
    }
}

