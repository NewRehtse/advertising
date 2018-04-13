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
class Image extends Media
{
    const VALID_FORMATS = 'jpg|png';

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        return false !== \strpos(self::VALID_FORMATS, $this->format()) && parent::isValid();
    }
}
