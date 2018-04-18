<?php

namespace Tests\App\MockedClasses;

/**
 * @author NewRehtse
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
