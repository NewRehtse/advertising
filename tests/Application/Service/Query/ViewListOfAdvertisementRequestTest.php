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
     * @param $data
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

