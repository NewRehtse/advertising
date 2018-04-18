<?php

namespace Tests\App\Domain\Model;

use App\Domain\Model\Image;
use App\Domain\Model\Position;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Domain\Model\Image
 */
class ImageTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateImageObject($data): void
    {
        $image = new Image($data['id'], $data['name'], $data['url']);

        $image->setFormat($data['format']);
        $image->setHeight($data['height']);
        $image->setWeight($data['weight']);
        $image->setWidth($data['width']);
        $image->setPosition($data['position']);

        $this->assertEquals($data['id'], $image->id());
        $this->assertEquals($data['height'], $image->height());
        $this->assertEquals($data['width'], $image->width());
        $this->assertEquals($data['weight'], $image->weight());
        $this->assertEquals($data['position'], $image->position());
        $this->assertEquals($data['formatResult'], $image->format());

        $this->assertEquals($data['valid'], $image->isValid());

        $image->setUrl('cambiada');
        $this->assertEquals('cambiada', $image->url());
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
                    'name' => 'adv1',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'formatResult' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => true,
                ],
            ],
            'format-no-valid' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'adv1',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'txt',
                    'formatResult' => null,
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => false,
                ],
            ],
            'name-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => '',
                    'url' => '/www.sunmedia.tv/campaing/adv1.mp4',
                    'format' => 'jpg',
                    'formatResult' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => false,
                ],
            ],
            'url-empty' => [
                [
                    'id' => $this->createMock(AppId::class),
                    'name' => 'adv1',
                    'url' => '',
                    'format' => 'jpg',
                    'formatResult' => 'jpg',
                    'height' => 300,
                    'width' => 300,
                    'weight' => 33,
                    'position' => $this->createMock(Position::class),
                    'valid' => false,
                ],
            ],
        ];
    }
}
