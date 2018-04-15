<?php

namespace Tests\App\Application\Service\Query;

use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Query\ViewListOfAdvertisementRequest
 */
class ViewListOfAdvertisementRequestTest extends TestCase
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
        $request = new ViewListOfAdvertisementRequest($data['limit'], $data['offset']);

        $this->assertInstanceOf(AppRequest::class, $request);
        $this->assertEquals($data['limit'], $request->limit());
        $this->assertEquals($data['offset'], $request->offset());
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                'uno' => [
                    'limit' => 10,
                    'offset' => 10,
                ],
            ],
        ];
    }
}
