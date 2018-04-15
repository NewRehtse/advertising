<?php

namespace Tests\App\Domain\Model;

use App\Domain\Model\Advertisement;
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
        $text->setAdvertisement($data['advertisement']);

        $this->assertEquals($data['id'], $text->id());
        $this->assertEquals($data['name'], $text->name());
        $this->assertEquals($data['textResult'], $text->text());
        $this->assertEquals($data['width'], $text->width());
        $this->assertEquals($data['height'], $text->height());
        $this->assertEquals($data['advertisement'], $text->advertisement());

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
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => 'name',
                    'text' => 'i am a valid advertisment',
                    'textResult' => 'i am a valid advertisment',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => true,
                ],
            ],
            'text-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => 'name',
                    'text' => 'i am not a valid advertisment because i am too large to be in an add i will get bored every user so nobody will buy what i am publishing and my publisher will be really really sad... and lorum ipsum',
                    'textResult' => null,
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
            'text-empty-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => 'name',
                    'text' => '',
                    'textResult' => null,
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
            'name-empty-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'advertisement' => $this->createMock(Advertisement::class),
                    'name' => '',
                    'text' => 'i am not a valid advertisment',
                    'textResult' => 'i am not a valid advertisment',
                    'position' => $this->createMock(Position::class),
                    'width' => 300,
                    'height' => 300,
                    'valid' => false,
                ],
            ],
        ];
    }
}
