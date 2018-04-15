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

use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author Antonio José Cerezo Aranda <acerezo@vocento.com>
 */
class AppIdTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateValidAppIdObject(): void
    {
        $id = '93j2093-83j2ojd39802-930ej2j8923';
        $advId = new AppId($id);

        $this->assertInstanceOf(AppId::class, $advId);
        $this->assertEquals($id, $advId->id());
    }

    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateValidSharedIdObject($data): void
    {
        $advId = new AppId($data['id']);

        $this->assertEquals($data['id'], $advId->id());
        $this->assertInstanceOf(AppId::class, $advId);

        $this->assertEquals($data['id'], $advId->__toString());
        $this->assertTrue($advId->equals($advId));

        $newAdvId = new AppId();
        $this->assertFalse($newAdvId->equals($advId));
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'uno' => [
                    'id' => 'identificador-1',
                ],
            ],
        ];
    }
}
