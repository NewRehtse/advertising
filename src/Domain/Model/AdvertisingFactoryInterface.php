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

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface AdvertisingFactoryInterface
{
    /**
     * @param AppId $id
     * @param Component[] $components
     * @param int $status
     *
     * @throws \Assert\AssertionFailedException
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return Advertisement
     */
    public function build(AppId $id, $components, $status = Advertisement::ADV_STATUS_PUBLISHED): Advertisement;

    /**
     * @param array $data
     *
     * @throws \Assert\AssertionFailedException
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return Advertisement
     */
    public function buildAdvertisementFromArray(array $data): Advertisement;

    /**
     * @param array $data
     *
     * @return Component
     */
    public function buildComponentFromArray(array $data): Component;

    /**
     * @param AppId|null $id
     *
     * @return AppId
     */
    public function buildAppId($id = null): AppId;

    /**
     * @param AppId  $id
     * @param string $name
     * @param string $url
     *
     * @return Image
     */
    public function buildImage(AppId $id, $name, $url): Image;

    /**
     * @param AppId  $id
     * @param string $name
     * @param string $url
     *
     * @return Video
     */
    public function buildVideo(AppId $id, $name, $url): Video;

    /**
     * @param AppId  $id
     * @param string $name
     * @param string $text
     *
     * @return Text
     */
    public function buildText(AppId $id, $name, $text): Text;

    /**
     * @param int $x
     * @param int $y
     * @param int $z
     *
     * @return Position
     */
    public function buildPosition($x, $y, $z): Position;
}
