<?php

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
