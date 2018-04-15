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


use App\Application\Service\Query\ViewDetailOfAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Query\ViewDetailOfAdvertisementRequest
 */
class ViewDetailOfAdvertisementRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param $data
     */
    public function shouldConstructValidViewListRequest($data): void
    {
        $request = new ViewDetailOfAdvertisementRequest($data['id']);

        $this->assertInstanceOf(AppRequest::class, $request);
        $this->assertEquals($data['id'], $request->id());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'uno' => [
                    'id' => 'id',
                ],
            ],
        ];
    }
}

