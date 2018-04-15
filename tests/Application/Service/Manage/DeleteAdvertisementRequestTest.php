<?php

namespace Tests\App\Application\Service\Manage;

use App\Application\Service\Manage\DeleteAdvertisementRequest;
use App\Domain\Model\AppRequest;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Application\Service\Manage\DeleteAdvertisementRequest
 */
class DeleteAdvertisementRequestTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldConstructValidDeleteRequeste($data): void
    {
        $request = new DeleteAdvertisementRequest($data['id']);

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
