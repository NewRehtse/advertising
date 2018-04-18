<?php

namespace Tests\App\Domain\Model;

use App\Domain\Model\Position;
use App\Domain\Model\Video;
use App\Domain\Model\AppId;
use PHPUnit\Framework\TestCase;

/**
 * @author NewRehtse
 *
 * @covers \App\Domain\Model\Video
 */
class VideoTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getData
     *
     * @param array $data
     */
    public function shouldCreateVideoObject($data): void
    {
        $video = new Video($data['id'], $data['name'], $data['url']);

        $video->setFormat($data['format']);
        $video->setHeight($data['height']);
        $video->setWeight($data['weight']);
        $video->setWidth($data['width']);
        $video->setPosition($data['position']);

        $this->assertEquals($data['id'], $video->id());
        $this->assertEquals($data['height'], $video->height());
        $this->assertEquals($data['width'], $video->width());
        $this->assertEquals($data['weight'], $video->weight());
        $this->assertEquals($data['position'], $video->position());
        $this->assertEquals($data['formatResult'], $video->format());

        $this->assertEquals($data['valid'], $video->isValid());

        $video->setUrl('cambiada');
        $this->assertEquals('cambiada', $video->url());
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
                    'format' => 'mp4',
                    'formatResult' => 'mp4',
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
                    'format' => 'webm',
                    'formatResult' => 'webm',
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
                    'format' => 'webm',
                    'formatResult' => 'webm',
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
