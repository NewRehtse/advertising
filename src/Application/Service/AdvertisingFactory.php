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
        $components = \array_merge($data['medias'], $data['texts']); //TODO ¿funcionara?

        return $this->build(new AppId($data['id']), $components, $data['status']);
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
