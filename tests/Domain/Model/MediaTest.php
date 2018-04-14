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

namespace Tests\App\Domain\Model;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use App\Domain\Model\Media;
use App\Domain\Model\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Domain\Model\Media
 */
class MediaTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateMediaObject($data): void
    {
        $media = $this->getMediaMock($data);

        $obj = new \ReflectionObject($media);

        $setFormatMethod = $obj->getMethod('setFormat');
        $setWeightMethod = $obj->getMethod('setWeight');
        $setAdvertisementMethod = $obj->getMethod('setAdvertisement');

        $formatMethod = $obj->getMethod('format');
        $weightMethod = $obj->getMethod('weight');
        $urlMethod = $obj->getMethod('url');
        $validMethod = $obj->getMethod('isValid');
        $advertisementMethod = $obj->getMethod('advertisement');

        $setFormatMethod->invokeArgs($media, [$data['format']]);
        $setWeightMethod->invokeArgs($media, [$data['weight']]);
        $setAdvertisementMethod->invokeArgs($media, [$data['advertisement']]);

        $this->assertEquals($data['url'], $urlMethod->invoke($media));
        $this->assertEquals($data['weight'], $weightMethod->invoke($media));
        $this->assertEquals($data['format'], $formatMethod->invoke($media));
        $this->assertEquals($data['advertisement'], $advertisementMethod->invoke($media));

        $this->assertEquals($data['valid'], $validMethod->invoke($media));
    }

    private function getMediaMock($data)
    {
        $media = $this->getMockBuilder(Media::class)
            ->setConstructorArgs([$data['id'], $data['name'], $data['url']])
            ->getMockForAbstractClass();

        return $media;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => 'adv1',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => true,
                ],
            ],
            'name-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => '',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => false,
                ],
            ],
            'url-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => 'adv1',
                    'url' => '',
                    'format' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => false,
                ],
            ],
        ];
    }
}
