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

use App\Domain\Model\Position;
use App\Domain\Model\Text;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \App\Domain\Model\Text
 */
class TextTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateTextObject($data): void
    {
        $text = new Text($data['id'], $data['name'], $data['text']);

        $text->setPosition($data['position']);
        $text->setWidth($data['width']);
        $text->setHeight($data['height']);

        $this->assertEquals($data['id'], $text->id());
        $this->assertEquals($data['name'], $text->name());
        $this->assertEquals($data['text'], $text->text());
        $this->assertEquals($data['width'], $text->width());
        $this->assertEquals($data['height'], $text->height());

        $this->assertEquals($data['valid'], $text->isValid());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'name',
                    'text' => 'i am a valid advertisment',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => true,
                ],
            ],
            'text-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'name',
                    'text' => 'i am not a valid advertisment because i am too large to be in an add i will get bored every user so nobody will buy what i am publishing and my publisher will be really really sad... and lorum ipsum',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
            'text-empty-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'name',
                    'text' => '',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
            'name-empty-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => '',
                    'text' => 'i am not a valid advertisment',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
        ];
    }
}
