<?php

namespace Tests\App\MockedClasses;

use App\Domain\Model\Component;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
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
