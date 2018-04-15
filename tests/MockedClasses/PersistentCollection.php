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

namespace Tests\App\MockedClasses;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class PersistentCollection
{
    private $iterator;

    public function setIterator($iterator)
    {
        $this->iterator = $iterator;
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}

