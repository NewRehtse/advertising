<?php

namespace Tests\App\Application\Service\Manage;

use App\Application\Service\Manage\CreateAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Manage\CreateAdvertisementRequest
 */
class CreateAdvertisementRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldConstructValidViewListRequest($data)
    {
        $request = new CreateAdvertisementRequest($data['status'], $data['components']);

        $this->assertInstanceOf(AppRequest::class, $request);
        $this->assertEquals($data['status'], $request->status());
        $this->assertEquals($data['components'], $request->components());
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                'uno' => [
                    'status' => 10,
                    'components' => ['array'],
                ],
            ],
        ];
    }
}
