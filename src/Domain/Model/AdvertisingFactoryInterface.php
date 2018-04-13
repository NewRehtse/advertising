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
    public function build();

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
