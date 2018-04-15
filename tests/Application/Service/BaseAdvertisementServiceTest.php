<?php

namespace Tests\App\Application\Service;

use App\Application\Service\AdvertisingFactory;
use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\Advertisement;
use App\Infrastructure\Persistence\Doctrine\AdvertisementRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\BaseAdvertisementService
 */
class BaseAdvertisementServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateValidBaseAdvertisementService(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true, true);

        /** @var BaseAdvertisementService $base */
        $base = $this->getBaseAdvertisementMock($advRepo);

        $obj = new \ReflectionObject($base);

        $factoryMethod = $obj->getMethod('factory');
        $factoryMethod->setAccessible(true);
        $advertisementRepositoryMethod = $obj->getMethod('advertisementRepository');
        $advertisementRepositoryMethod->setAccessible(true);
        $findOrFailMethod = $obj->getMethod('findOrFail');
        $findOrFailMethod->setAccessible(true);

        $this->assertInstanceOf(AdvertisingFactory::class, $factoryMethod->invoke($base));
        $this->assertEquals($advRepo, $advertisementRepositoryMethod->invoke($base));
        $this->assertInstanceOf(Advertisement::class, $findOrFailMethod->invokeArgs($base, ['id']));
    }

    /**
     * @test
     *
     * @expectedException \App\Domain\Model\Exceptions\ElementNotFound
     */
    public function shouldCreateValidBaseAdvertisementServiceButNotFound(): void
    {
        /** @var AdvertisementRepository $advRepo */
        $advRepo = $this->getAdvertisementRepositoryMock(true, false);

        /** @var BaseAdvertisementService $base */
        $base = $this->getBaseAdvertisementMock($advRepo);

        $obj = new \ReflectionObject($base);

        $findOrFailMethod = $obj->getMethod('findOrFail');
        $findOrFailMethod->setAccessible(true);

        $findOrFailMethod->invokeArgs($base, ['id']);
    }

    /**
     * @param AdvertisementRepository $advRepo
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getBaseAdvertisementMock($advRepo): \PHPUnit\Framework\MockObject\MockObject
    {
        return $this->getMockBuilder(BaseAdvertisementService::class)
            ->setConstructorArgs([$advRepo, new AdvertisingFactory()])
            ->getMockForAbstractClass();
    }

    /**
     * @param bool $getById
     * @param bool $find
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAdvertisementRepositoryMock($getById = true, $find = true): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder(AdvertisementRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $advertisement = $find ? $this->getAdvertisementMock() : null;
        if ($getById) {
            $mock->expects($this->once())
                ->method('getById')
                ->willReturn($advertisement);
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
