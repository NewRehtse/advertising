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

namespace Tests\App\Application\Service\Manage;


use App\Application\Service\Manage\CreateAdvertisementRequest;
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
     * @param $data
     */
    public function shouldConstructValidViewListRequest($data)
    {
        $request = new CreateAdvertisementRequest($data['status'], $data['components']);

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

