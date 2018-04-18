<?php


namespace Tests\App\MockedClasses;

use App\Domain\Model\Component;

/**
 * @author NewRehtse
 */
class ComponentNotAdded extends Component
{
    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }
}
