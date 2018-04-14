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

namespace App\Application\Service\DataTransformer;

use App\Domain\Model\Advertisement;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface AdvertisementDataTransformerInterface
{
    /**
     * @param Advertisement $adv
     */
    public function write(Advertisement $adv): void;

    /**
     * @param bool $raw
     *
     * @return array
     */
    public function read($raw = false): array;

}

