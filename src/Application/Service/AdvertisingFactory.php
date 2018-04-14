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

namespace App\Application\Service;

use App\Domain\Model\Advertisement;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppId;
use App\Domain\Model\Component;
use App\Domain\Model\Image;
use App\Domain\Model\Position;
use App\Domain\Model\Text;
use App\Domain\Model\Video;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
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
    public function buildComponentFromArray(array $data): Component
    {
        $c = null;
        $componentId = $this->buildAppId($data['id']);
        if (isset($data['text'])) {
            $c = $this->buildText($componentId, $data['name'], $data['text']);
        }
        if (isset($data['format'], $data['url']) && \strpos(Video::VALID_FORMATS, $data['format']) ) {
            $c = $this->buildVideo($componentId, $data['name'], $data['url']);
        }

        if (isset($data['format'], $data['url']) && \strpos(Image::VALID_FORMATS, $data['format']) ) {
            $c = $this->buildVideo($componentId, $data['name'], $data['url']);
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
        // TODO: Implement buildImage() method.
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
        // TODO: Implement buildVideo() method.
    }

    /**
     * @inheritdoc
     */
    public function buildText(AppId $id, $name, $text): Text
    {
        // TODO: Implement buildText() method.
    }

    /**
     * @inheritdoc
     */
    public function buildPosition($x, $y, $z): Position
    {
        // TODO: Implement buildPosition() method.
    }
}
