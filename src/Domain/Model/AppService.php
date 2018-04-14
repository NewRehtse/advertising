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
interface AppService
{
    /**
     * @param AppRequest|null $request
     *
     * @throws \InvalidArgumentException
     */
    public function execute(AppRequest $request = null);
}

