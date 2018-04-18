<?php

namespace App\Application\Service;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppId;
use App\Domain\Model\Image;
use App\Domain\Model\Position;
use App\Domain\Model\Text;
use App\Domain\Model\Video;

/**
 * @author NewRehtse
 */
class AdvertisingFactory implements AdvertisingFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function build(AppId $id, $components, $status = Advertisement::ADV_STATUS_PUBLISHED): Advertisement
    {
        return new Advertisement($id, $components, $status);
    }

    /**
     * @inheritdoc
     */
    public function buildAdvertisementFromArray(array $data): Advertisement
    {
        $components = [];
        if (isset($data['components'])) { // Esto es lo que viene desde el repositorio
            /** @var array $c */
            foreach ($data['components'] as $c) {
                $components[] = $this->buildComponentFromArray($c);
            }
        }

        return $this->build(new AppId($data['id']), $components, $data['status']);
    }

    /**
     * @inheritdoc
     */
    public function buildComponentFromArray(array $data)
    {
        $c = null;
        $componentId = $this->buildAppId($data['id'] ?? null);
        if (isset($data['text'])) {
            $c = $this->buildText($componentId, $data['name'], $data['text']);
        }
        if (isset($data['format'], $data['url']) && false !== \strpos(Video::VALID_FORMATS, $data['format'])) {
            $c = $this->buildVideo($componentId, $data['name'], $data['url']);
            $c->setFormat($data['format']);

            if (isset($data['weight'])) {
                $c->setWeight($data['weight']);
            }
        }

        if (isset($data['format'], $data['url']) && false !== \strpos(Image::VALID_FORMATS, $data['format'])) {
            $c = $this->buildImage($componentId, $data['name'], $data['url']);
            $c->setFormat($data['format']);

            if (isset($data['weight'])) {
                $c->setWeight($data['weight']);
            }
        }

        if (isset($c)) {
            if (isset($data['positionX'], $data['positionY'], $data['positionZ'])) {
                $c->setPosition($this->buildPosition($data['positionX'], $data['positionY'], $data['positionZ']));
            }

            if (isset($data['width'])) {
                $c->setWidth($data['width']);
            }

            if (isset($data['height'])) {
                $c->setHeight($data['height']);
            }
        }

        return $c;
    }

    /**
     * @inheritdoc
     */
    public function buildImage(AppId $id, $name, $url): Image
    {
        return new Image($id, $name, $url);
    }

    /**
     * @inheritdoc
     */
    public function buildAppId($id = null): AppId
    {
        return new AppId($id);
    }

    /**
     * @inheritdoc
     */
    public function buildVideo(AppId $id, $name, $url): Video
    {
        return new Video($id, $name, $url);
    }

    /**
     * @inheritdoc
     */
    public function buildText(AppId $id, $name, $text): Text
    {
        return new Text($id, $name, $text);
    }

    /**
     * @inheritdoc
     */
    public function buildPosition($x, $y, $z): Position
    {
        return new Position($x, $y, $z);
    }
}
