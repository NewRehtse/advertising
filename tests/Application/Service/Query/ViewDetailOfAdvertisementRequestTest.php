<?php

namespace Tests\App\Application\Service\Query;

use App\Application\Service\Query\ViewDetailOfAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
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
     * @param array $data
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
