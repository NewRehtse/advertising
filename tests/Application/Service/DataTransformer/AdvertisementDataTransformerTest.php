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

namespace Tests\App\Application\Service\DataTransformer;


use App\Application\Service\AdvertisingFactory;
use App\Application\Service\DataTransformer\AdvertisementDataTransformer;
use App\Domain\Model\Advertisement;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\DataTransformer\AdvertisementDataTransformer
 */
class AdvertisementDataTransformerTest extends TestCase
{
    /** @var AdvertisementDataTransformer */
    private $dataTransformer;
    /** @var  AdvertisingFactory */
    private $factory;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->dataTransformer = new AdvertisementDataTransformer();
        $this->factory = new AdvertisingFactory();
    }

    /**
     * @test
     *
     * @dataProvider getAdvArrayData
     *
     * @param $data
     */
    public function shouldReturnArrayWithCorrectStructure($data)
    {
        $adv = $this->factory->buildAdvertisementFromArray($data);
        $this->dataTransformer->write($adv);

        $arr = $this->dataTransformer->read();

        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('status', $arr);
        $this->assertArrayHasKey('components', $arr);
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
}

