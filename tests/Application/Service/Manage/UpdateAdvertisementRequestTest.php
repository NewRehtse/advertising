<?php

namespace Tests\App\Application\Service\Manage;

use App\Application\Service\Manage\UpdateAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Application\Service\Manage\UpdateAdvertisementRequest
 */
class UpdateAdvertisementRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateValidRequest($data)
    {
        $request = new UpdateAdvertisementRequest($data['id'], $data['components'], $data['status']);

        $this->assertInstanceOf(AppRequest::class, $request);
        $this->assertEquals($data['id'], $request->id());
        $this->assertEquals($data['components'], $request->components());
        $this->assertEquals($data['status'], $request->status());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                [
                    'id' => 'id',
                    'status' => 3,
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
                            'id' => 'id',
                            'text' => 'text',
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
