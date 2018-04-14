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
class Video extends Media
{
    public const VALID_FORMATS = 'mp4|webm';

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return false !== \strpos(self::VALID_FORMATS, $this->format()) && parent::isValid();
    }
}
